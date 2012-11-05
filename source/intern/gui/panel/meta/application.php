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
 * Panel to write an application for a meta.
 */
class Rakuun_Intern_GUI_Panel_Meta_Application extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		if (!$this->getModule()->getParam('meta')) {
			$this->addError('Seitenaufruf ohne Meta Parameter.');
			return;
		}
		$this->setTemplate(dirname(__FILE__).'/application.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();
		if ($user->alliance->meta)
			$this->addError('Deine Allianz ist bereits in einer Meta.');
		$this->addPanel($text = new GUI_Control_TextArea('text'));
		$text->setTitle('Bewerbungstext');
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Bewerben'));
	}
	
	public function onSubmit() {
		if (Rakuun_GameSecurity::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_GameSecurity::GROUP_DEMO))
			$this->addError('Demo-User darf sich mit seiner Allianz bei keiner Meta bewerben.');

		if ($this->hasErrors())
			return;
			
		DB_Connection::get()->beginTransaction();
		//Save the application
		$application = new DB_Record();
		$application->alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		$application->meta = $this->getModule()->getParam('meta');
		$application->text = $this->text;
		$application->date = time();
		Rakuun_DB_Containers::getMetasApplicationsContainer()->save($application);
		//Find meta-alliances
		$alliances = Rakuun_DB_Containers::getAlliancesContainer()->selectByMeta($this->getModule()->getParam('meta'));
		foreach ($alliances as $alliance) {
			//Send an igm to all privileged Members of the alliances
			$users = Rakuun_Intern_Alliance_Security::getForAllianceById($alliance->getPK())->getGroupUsers(Rakuun_Intern_Alliance_Security::GROUP_LEADERS);
			foreach ($users as $user) {
				$igm = new Rakuun_Intern_IGM('Neue Meta Bewerbung', $user);
				$igm->type = Rakuun_Intern_IGM::TYPE_META;
				$igm->setSenderName(Rakuun_Intern_IGM::SENDER_META);
				$igm->setText(
					'Hallo '.$user->name.',<br />
					['.Rakuun_User_Manager::getCurrentUser()->alliance->tag.'] '.Rakuun_User_Manager::getCurrentUser()->alliance->name.' hat sich bei eurer Meta beworben.'
				);
				$igm->send();
			}
		}
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Bewerbung abgeschickt.');
	}
}

?>