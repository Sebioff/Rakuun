<?php

class Rakuun_Index_Panel_Register extends GUI_Panel {
	private static $reservedNames = array('SYSTEM', 'YIMTAY', 'SUPPORT', 'MULTIHUNTER', 'ADMIN');
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
		$this->addPanel(new GUI_Control_SubmitButton('submit', I18N::translate('Anmelden')));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		if (!Rakuun_User_Manager::isMasterUser() && (!RAKUUN_REGISTRATION_ENABLED || RAKUUN_ROUND_STARTTIME > time()) && (!Rakuun_User_Manager::getCurrentUser() || !Rakuun_TeamSecurity::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_TeamSecurity::PRIVILEGE_BACKENDACCESS))) {
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
			
		if (preg_match('/[<>,]+/', $this->username->getValue()))
			$this->addError('Dieser Name enhält nicht erlaubte Zeichen', $this->username);

		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$user = new Rakuun_DB_User();
		$user->name = $this->username;
		$user->salt = md5(time() / rand());
		$user->password = Rakuun_User_Manager::cryptPassword($this->password, $user->salt);
		$user->registrationTime = time();
		$user->mail = $this->mail;
		$user->skin = 'tech';
		$user->isInNoob = true;
		if ($user->name[Text::length($user->name) - 1] == 's')
			$user->cityName = $user->name.'\' Stadt';
		else
			$user->cityName = $user->name.'s Stadt';
		$coordinateGenerator = new Rakuun_Intern_Map_CoordinateGenerator();
		$position = $coordinateGenerator->getRandomFreeCoordinate();
		$user->cityX = $position[0];
		$user->cityY = $position[1];
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
		
		Rakuun_Intern_Log_UserActivity::log($user, Rakuun_Intern_Log::ACTION_ACTIVITY_REGISTRATION, base64_decode($this->base64->getValue()));
		DB_Connection::get()->commit();
		
		try {
			$mail = new Net_Mail();
			$mail->setSubject('Rakuun: Anmeldung');
			$mail->addRecipients($user->nameUncolored.' <'.$user->mail.'>');
			$params = array('code' => $activation->code);
			$activationURL = App::get()->getActivationModule()->getURL($params);
			$templateEngine = new GUI_TemplateEngine();
			$templateEngine->username = $user->nameUncolored;
			$templateEngine->password = $this->password;
			$templateEngine->activationURL = $activationURL;
			// TODO modify content (might not be correct in the new version)
			$mail->setMessage($templateEngine->render(dirname(__FILE__).'/register_mail.tpl'));
			$mail->send();
		}
		catch (Core_Exception $e) {
			IO_Log::get()->error($e->getTraceAsString());
		}
		
		$igm = new Rakuun_Intern_IGM('Willkommen!', $user);
		// TODO modify content (might not be correct in the new version)
		$igm->setText(
			'Hi '.$user->name.',<br/>
			willkommen auf Rakuun!
			<br>
			Falls du Probleme bei Rakuun hast, kannst du den <a href="nachrichten.php?derempf=Support"><u>Support</u></a> anschreiben
			 - wir beantworten alle deine Fragen gerne! Ansonsten kann dir auch die <span class="rahelp" help="help">Rakuun Hilfe</span> weiterhelfen: durch einen Klick auf unterstrichelte und mit dem <img src="Grafik/space2/help.gif" alt="" border="0">-Symbol markierte Begriffe erhältst du mehr Informationen zum entsprechenden Thema. Probier es doch direkt mal aus, indem du hier auf "<span class="rahelp" help="help">Rakuun Hilfe</span>" klickst!
			<br/>
			<br/>
			<a href="http://www.rakuun.de/eoleon/phpBB2/viewtopic.php?t=704" target="_blank"><u>Hier</u></a> findest du einen Artikel aus dem <a href="http://infocenter.rakuun.de" target="_blank">Rakuun Infocenter</a>, der neuen Spielern den Einstieg erleichtern soll.
			<br/>
			<br/>
			Du kannst auch gerne in unser Forum (<a href="http://forum.rakuun.de" target="_blank"><u>http://forum.rakuun.de</u></a>) oder in unseren IRC-Channel (Server: Gamesurge (irc.gamesurge.net), Channel: #rakuun) kommen!
			<br/>
			<br/>
			Zur Zeit steht dein Account unter <b>Schutz</b>, d.h. er kann nicht angegriffen werden!
			<br/>
			Wie lange dieser Schutz besteht, kannst du auf deiner Startseite sehen.
			<br/>
			Früher oder später wird er allerdings verfallen. Vielleicht willst du ja einer <a href="allianzen.php">Allianz</a> beitreten? Diese können zum Schutz gegen ressourcenhungrige Nachbarn sehr nützlich sein.
			<br/>
			Falls du nicht mehr im Noobschutz bist und ständig angegriffen wirst und keine Chance siehst, dich zu verteidigen, jedoch trotzdem weiterspielen willst, kannst du in den <b>Kriegsopfermodus</b> wechseln.
			<br/>
			Dieser Modus erlaubt dir, weiterzuspielen, ohne angegriffen zu werden - allerdings kannst du selbst auch nicht mehr angreifen und Ressourcen übertragen oder erhalten.
			<br/>
			Viel Spass bei Rakuun!'
		);
		$igm->setSenderName(Rakuun_Intern_IGM::SENDER_SYSTEM);
		$igm->send();
		
		$this->setTemplate(dirname(__FILE__).'/register_successful.tpl');
	}

	public static function getReservedNames() {
		return array_unique(array_merge(self::$reservedNames, Rakuun_Intern_IGM::getReservedNames()));
	}
}

?>