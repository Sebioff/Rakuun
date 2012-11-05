<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

class Rakuun_Index_Panel_Register extends GUI_Panel {
	private static $reservedNames = array('SYSTEM', 'YIMTAY', 'SUPPORT', 'MULTIHUNTER', 'ADMIN');
	private $restrictedChars = '%@<>,#\'"';
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/register.tpl');
		
		$this->addPanel($username = new GUI_Control_TextBox('username', null, 'Nickname'));
		$username->addValidator(new GUI_Validator_RangeLength(2, 25));
		$username->addValidator(new GUI_Validator_Mandatory());
		$username->addValidator(new Rakuun_GUI_Validator_Name());
		$username->setFocus();
		$this->addPanel($password = new GUI_Control_PasswordBox('password', null, 'Passwort'));
		$password->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($password_repeat = new GUI_Control_PasswordBox('password_repeat', null, 'Passwort (Wiederholung)'));
		$password_repeat->addValidator(new GUI_Validator_Mandatory());
		$password_repeat->addValidator(new GUI_Validator_Equals($password));
		$this->addPanel($mail = new GUI_Control_TextBox('mail', null, 'EMail-Adresse'));
		$mail->addValidator(new GUI_Validator_Mandatory());
		$mail->addValidator(new GUI_Validator_Mail());
		$this->addPanel(new GUI_Control_HiddenBox('base64'));
		$this->addPanel($submit = new GUI_Control_SubmitButton('submit', I18N::translate('Anmelden')));
		$submit->addClasses('core_gui_button_highlighted');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		if (Rakuun_Game::isRegistrationDisabled()) {
			$this->setTemplate(dirname(__FILE__).'/register_disabled.tpl');
			return;
		}
		
		$module = Router::get()->getCurrentModule();
		$module->addJsRouteReference('core_js', 'base64.js');
		$module->addJsAfterContent(sprintf('var string = base64.encode(screen.width + " * " + screen.height + ", " + screen.colorDepth); $("#%s").val(string);', $this->base64->getID()));
	}
	
	public function onSubmit() {
		$userExists = Rakuun_DB_Containers::getUserContainer()->select(array('conditions' => array(array('name LIKE ?', $this->username))));
		
		if ($userExists)
			$this->addError('Es existiert bereits ein Spieler mit diesem Namen', $this->username);
		
		if (in_array(Text::toUpperCase($this->username->getValue()), self::getReservedNames()))
			$this->addError('Dieser Name kann nicht vergeben werden', $this->username);
			
		if (preg_match('/['.$this->restrictedChars.']+/', $this->username->getValue()))
			$this->addError('Folgende Zeichen sind im Namen nicht erlaubt: '.stripslashes($this->restrictedChars), $this->username);

		if ($this->hasErrors())
			return;
			
		$user = self::registerUser($this->username->getValue(), $this->password->getValue(), $this->mail->getValue());
		Rakuun_Intern_Log_UserActivity::log($user, Rakuun_Intern_Log::ACTION_ACTIVITY_REGISTRATION, base64_decode($this->base64->getValue()));
		
		$this->setTemplate(dirname(__FILE__).'/register_successful.tpl');
	}
	
	/**
	 * Registers a new user
	 * @param string $name
	 * @param string $password
	 * @param string $mail
	 * @return Rakuun_DB_User the newly created user
	 */
	public static function registerUser($name, $password, $mail = '') {
		DB_Connection::get()->beginTransaction();
		$user = new Rakuun_DB_User();
		$user->name = $name;
		$user->salt = md5(time() / rand());
		$user->password = Rakuun_User_Manager::cryptPassword($password, $user->salt);
		$user->registrationTime = time();
		$user->mail = $mail;
		$user->skin = 'tech';
		$user->isInNoob = true;
		if ($user->name[Text::length($user->name) - 1] == 's')
			$user->cityName = $user->name.'\' Stadt';
		else
			$user->cityName = $user->name.'s Stadt';
		$coordinateGenerator = Rakuun_Intern_Mode::getCurrentMode()->getCoordinateGenerator();
		$position = $coordinateGenerator->getRandomFreeCoordinate();
		$user->cityX = $position[0];
		$user->cityY = $position[1];
		Rakuun_Intern_Mode::getCurrentMode()->onNewUser($user);
		Rakuun_DB_Containers::getUserContainer()->save($user);
		
		$activation = new DB_Record();
		$activation->user = $user;
		$activation->code = md5(microtime());
		$activation->time = time();
		Rakuun_DB_Containers::getUserActivationContainer()->save($activation);
		
		$buildings = new DB_Record();
		$buildings->user = $user;
		$buildings->ironmine = 1;
		$buildings->berylliummine = 1;
		$buildings->ironstore = 1;
		$buildings->berylliumstore = 1;
		$buildings->energystore = 1;
		$buildings->house = 1;
		$buildings->themepark = 1;
		Rakuun_DB_Containers::getBuildingsContainer()->save($buildings);
		
		$ressources = new Rakuun_DB_Ressources();
		$ressources->user = $user;
		$ressources->iron = $ressources->getCapacityIron();
		$ressources->beryllium = $ressources->getCapacityBeryllium();
		$ressources->energy = $ressources->getCapacityEnergy();
		$ressources->people = $ressources->getCapacityPeople();
		$ressources->tick = time();
		Rakuun_DB_Containers::getRessourcesContainer()->save($ressources);
		
		$buildingsWorkers = new DB_Record();
		$buildingsWorkers->user = $user;
		$buildingsWorkers->ironmine = 50;
		$buildingsWorkers->berylliummine = 50;
		Rakuun_DB_Containers::getBuildingsWorkersContainer()->save($buildingsWorkers);
		
		$technologies = new DB_Record();
		$technologies->user = $user;
		Rakuun_DB_Containers::getTechnologiesContainer()->save($technologies);
		
		$units = new DB_Record();
		$units->user = $user;
		$units->buildings = $buildings;
		$units->technologies = $technologies;
		$units->fightingSequence = Rakuun_Intern_Production_Unit::DEFAULT_DEFENSE_SEQUENCE;
		$units->attackSequence = Rakuun_Intern_Production_Unit::DEFAULT_ATTACK_SEQUENCE;
		Rakuun_DB_Containers::getUnitsContainer()->save($units);
		
		Rakuun_Intern_Log_Userdata::log($user, Rakuun_Intern_Log::ACTION_USERDATA_EMAIL, $user->mail);
		Rakuun_Intern_Log_Userdata::log($user, Rakuun_Intern_Log::ACTION_USERDATA_PASSWORD, $user->password);
		DB_Connection::get()->commit();
		
		if ($user->mail) {
			/*
			 * Catching exceptions here because sending mails is usually not possible
			 * on DEV and that's annoying for testing.
			 */
			try {
				$mail = new Net_Mail();
				$mail->setSubject('Rakuun: Anmeldung');
				$mail->addRecipients($user->nameUncolored.' <'.$user->mail.'>');
				$params = array('code' => $activation->code);
				$activationURL = App::get()->getActivationModule()->getURL($params);
				$templateEngine = new GUI_TemplateEngine();
				$templateEngine->username = $user->nameUncolored;
				$templateEngine->password = '-dir bekannt-';
				$templateEngine->activationURL = $activationURL;
				$mail->setMessage($templateEngine->render(dirname(__FILE__).'/register_mail.tpl'));
				$mail->send();
			}
			catch (Core_Exception $e) {
				IO_Log::get()->error($e->getTraceAsString());
			}
		}
		
		// links
		$supportlink = new GUI_Control_Link('supportlink', 'Support', App::get()->getInternModule()->getSubmodule('messages')->getUrl());
		$ticketlink = new GUI_Control_Link('ticketlink', 'Ticketsystem', 'http://tickets.rakuun.de');
		
		$igm = new Rakuun_Intern_IGM('Willkommen!', $user);
		$igm->setText(
			'Hi '.$user->name.',<br/>
			<b>willkommen auf Rakuun!</b>
			<br/>
			Als erstes solltest du das Tutorial meistern. Der Tutor (immer oben auf jeder Seite) wird dir alles, was du für den Anfang brauchst, genau erklären.
			Hier werden dir auch schon viele Tipps gegeben.
			<br/>
			Falls du Probleme bei Rakuun hast, kannst du den '.$supportlink->render()
			.' anschreiben - wir beantworten alle deine Fragen gerne!
			Ansonsten kannst du deine Fragen auch in der Shoutbox stellen.
			Du kannst auch gerne in unser '.$ticketlink->render().'
			oder in unseren IRC-Channel (Server: Gamesurge (irc.gamesurge.net), Channel: #rakuun) kommen!
			<br/>
			Zur Zeit steht dein Account unter <b>Schutz</b>, d.h. er kann nicht
			angegriffen werden!
			Wie lange dieser Schutz besteht, kannst du auf deiner Startseite sehen.
			Früher oder später wird er allerdings verfallen. Sobald du den Schutz verlassen hast, kannst du jederzeit in den Schutz
			zurückkehren, wenn du die Voraussetzungen wieder erfüllst.
			<br/>
			<i>Viel Spass bei Rakuun wünscht das Rakuun-Team!</i>'
		);
		$igm->setSenderName(Rakuun_Intern_IGM::SENDER_SYSTEM);
		$igm->send();
		
		return $user;
	}

	public static function getReservedNames() {
		return array_unique(array_merge(self::$reservedNames, Rakuun_Intern_IGM::getReservedNames()));
	}
}

?>