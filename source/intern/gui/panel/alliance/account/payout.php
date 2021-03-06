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

/**
 * Panel to display the alliance account
 */
class Rakuun_Intern_GUI_Panel_Alliance_Account_Payout extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/payout.tpl');
		$alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		$users = $alliance->members;
		$averageStrength = $alliance->getAverageMilitaryStrength(true);
		$averagePoints = $alliance->points / count($users);
		$this->params->averageStrength = $averageStrength;
		$this->params->averagePoints = $averagePoints;
		$_users = array();
		foreach ($users as $user) {
			if ($user->getArmyStrength(true) < $averageStrength && $user->points < $averagePoints)
				$_users[$user->getPK()] = $user->name;
		}
		$defaultuser = null;
		if (in_array(Rakuun_User_Manager::getCurrentUser(), $_users)) {
			$defaultuser = Rakuun_User_Manager::getCurrentUser();
		}
		$this->addPanel($userbox = new GUI_Control_DropDownBox('userbox', $_users, $defaultuser));
		$userbox->setTitle('Empfänger:');
		$this->addPanel($iron = new GUI_Control_DigitBox('iron', 0));
		$iron->setTitle('Eisen:');
		$iron->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($beryllium = new GUI_Control_DigitBox('beryllium', 0));
		$beryllium->setTitle('Beryllium:');
		$beryllium->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($energy = new GUI_Control_DigitBox('energy', 0));
		$energy->setTitle('Energie:');
		$energy->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($people = new GUI_Control_DigitBox('people', 0));
		$people->setTitle('Leute:');
		$people->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'auszahlen'));
	}
	
	public function onSubmit() {
		DB_Connection::get()->beginTransaction();
		$alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		$options['conditions'][] = array('id = ?', $this->userbox->getKey());
		$options['conditions'][] = array('alliance = ?', $alliance);
		$user = Rakuun_DB_Containers::getUserContainer()->selectFirst($options);
		$options = array();
		$options['lock'] = DB_Container::LOCK_FOR_UPDATE;
		$ressources = Rakuun_DB_Containers::getRessourcesContainer()->selectByUserFirst($user, $options);
		
		if (!$user) {
			if (!$this->userbox->getKey())
				$this->addError('Kein Spieler ausgewählt.');
			else
				$this->addError($this->userbox->getValue().' gehört nicht zu deiner Allianz.');
			//return here so user can't see store capacity of enemies
			return;
		}
		
		if ($this->iron->getValue()+ $this->beryllium->getValue() + $this->energy->getValue() + $this->people->getValue() == 0)
			$this->addError('Keine Ressourcen zu übertragen.');
		
		//check for user capacity
		if ($this->iron->getValue() + $ressources->iron > $ressources->getCapacityIron()) {
			$capacity = $ressources->getCapacityIron() - $ressources->iron;
			$this->addError($user->name.' kann nur noch '.$capacity.' Eisen empfangen.');
			$this->iron->setValue($capacity);
		}
		if ($this->beryllium->getValue() + $ressources->beryllium > $ressources->getCapacityBeryllium()) {
			$capacity = $ressources->getCapacityBeryllium() - $ressources->beryllium;
			$this->addError($user->name.' kann nur noch '.$capacity.' Beryllium empfangen.');
			$this->beryllium->setValue($capacity);
		}
		if ($this->energy->getValue() + $ressources->energy > $ressources->getCapacityEnergy()) {
			$capacity = $ressources->getCapacityEnergy() - $ressources->energy;
			$this->addError($user->name.' kann nur noch '.$capacity.' Energie empfangen.');
			$this->energy->setValue($capacity);
		}
		if ($this->people->getValue() + $ressources->people > $ressources->getCapacityPeople()) {
			$capacity = $ressources->getCapacityPeople() - $ressources->people;
			$this->addError($user->name.' kann nur noch '.$capacity.' Leute empfangen.');
			$this->people->setValue($capacity);
		}
		
		//check if alliance owns enough ressources
		if ($this->iron->getValue() > $alliance->iron)
			$this->addError('So viel Eisen befindet sich nicht in der Allianzkasse.');
		if ($this->beryllium->getValue() > $alliance->beryllium)
			$this->addError('So viel Beryllium befindet sich nicht in der Allianzkasse.');
		if ($this->energy->getValue() > $alliance->energy)
			$this->addError('So viel Energie befindet sich nicht in der Allianzkasse.');
		if ($this->people->getValue() > $alliance->people)
			$this->addError('So viele Leute befinden sich nicht in der Allianzkasse.');
		
		//check if user armee is below alliance average
		if ($user->getArmyStrength(true) >= $user->alliance->getAverageMilitaryStrength(true))
			$this->addError('Dieser Spieler besitzt eine zu starke Armee, um noch mit Ressourcen gestärkt werden zu müssen.');

		if ($user->points >= $alliance->points / count($alliance->members))
			$this->addError('Dieser Spieler hat zu viele Punkte.');
		
		if ($this->hasErrors()) {
			DB_Connection::get()->rollback();
			return;
		}
		
		$ressources->raise($this->iron->getValue(), $this->beryllium->getValue(), $this->energy->getValue(), $this->people->getValue());
		$alliance->lower($this->iron->getValue(), $this->beryllium->getValue(), $this->energy->getValue(), $this->people->getValue());
		$log = new DB_Record();
		$log->alliance = $user->alliance;
		$log->receiver = $user;
		$log->sender = Rakuun_User_Manager::getCurrentUser();
		$log->iron = $this->iron->getValue();
		$log->beryllium = $this->beryllium->getValue();
		$log->energy = $this->energy->getValue();
		$log->people = $this->people->getValue();
		$log->date = time();
		$log->type = Rakuun_Intern_GUI_Panel_Alliance_Account::TYPE_ALLIANCE_TO_USER;
		Rakuun_DB_Containers::getAlliancesAccountlogContainer()->save($log);
		Rakuun_Intern_Log_Ressourcetransfer::log($user, Rakuun_Intern_Log::ACTION_RESSOURCES_ALLIANCE, $log->sender, $log->iron, $log->beryllium, $log->energy, $log->people);
		$igm = new Rakuun_Intern_IGM('Überweisung aus Allianzkasse', $user);
		$igm->type = Rakuun_Intern_IGM::TYPE_TRADE;
		$igm->setSenderName(Rakuun_Intern_IGM::SENDER_ALLIANCE);
		$igm->setText(
			'Dir wurden durch '.Rakuun_User_Manager::getCurrentUser()->name.' folgende Rohstoffe aus der Allianzkasse überwiesen:
			<ul>
				<li>'.Text::formatNumber($this->iron->getValue()).' Eisen</li>
				<li>'.Text::formatNumber($this->beryllium->getValue()).' Beryllium</li>
				<li>'.Text::formatNumber($this->energy->getValue()).' Energie</li>
				<li>'.Text::formatNumber($this->people->getValue()).' Leute</li>
			</ul>'
		);
		$igm->send();
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Auszahlung erfolgreich.');
		$this->getModule()->invalidate();
	}
}

?>