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
 * Class to handle the meta applications.
 */
class Rakuun_Intern_GUI_Panel_Meta_Applications extends GUI_Panel {
	const ACTION_NOTHING = 0;
	const ACTION_HIRE = 1;
	const ACTION_FIRE = 2;
	
	private $applications = array();
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/applications.tpl');
		$applications = Rakuun_DB_Containers::getMetasApplicationsContainer()->selectByMeta(Rakuun_User_Manager::getCurrentUser()->alliance->meta, array('order' => 'date DESC'));
		foreach ($applications as $application) {
			$list = new GUI_Control_RadioButtonList('application_'.$application->id);
			$hire = new GUI_Control_RadioButton('hire', self::ACTION_HIRE);
			$hire->setTitle('annehmen');
			$list->addItemRadiobutton($hire);
			$fire = new GUI_Control_RadioButton('fire', self::ACTION_FIRE);
			$fire->setTitle('ablehnen');
			$list->addItemRadiobutton($fire);
			$none = new GUI_Control_RadioButton('none', self::ACTION_NOTHING, true, 'nichts');
			$list->addItemRadiobutton($none);
			$this->applications[] = array('options' => $list, 'record' => $application);
		}
		$this->params->applications = $this->applications;
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Übernehmen'));
	}
	
	public function onSubmit() {
		if (Rakuun_GameSecurity::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_GameSecurity::GROUP_DEMO))
			$this->addError('Demo-User darf keine Allianzen in seine Meta aufnehmen.');
		
		if ($this->hasErrors())
			return;
		
		$hires = array();
		$fires = array();
		$nothing = 0;
		DB_Connection::get()->beginTransaction();
		$meta = Rakuun_User_Manager::getCurrentUser()->alliance->meta;
		foreach ($this->applications as $application) {
			$users = Rakuun_Intern_Alliance_Security::getForAlliance($application['record']->alliance)->getGroupUsers(Rakuun_Intern_Alliance_Security::GROUP_LEADERS);
			switch ($application['options']->getValue()) {
				case self::ACTION_FIRE:
					foreach ($users as $user) {
						$igm = new Rakuun_Intern_IGM('Bewerbung bei '.$meta->name.' abgelehnt', $user);
						$igm->type = Rakuun_Intern_IGM::TYPE_META;
						$igm->setSenderName(Rakuun_Intern_IGM::SENDER_META);
						$igm->setText(
							'Hallo '.$user->name.',<br />'.
							'['.Rakuun_User_Manager::getCurrentUser()->alliance->tag.'] '.Rakuun_User_Manager::getCurrentUser()->alliance->name.' hat eure Metabewerbung abgelehnt.'
						);
						$igm->send();
					}
					Rakuun_DB_Containers::getMetasApplicationsContainer()->delete($application['record']);
				break;
				case self::ACTION_HIRE:
					$alliance = $application['record']->alliance;
					$alliance->meta = $meta;
					Rakuun_DB_Containers::getAlliancesContainer()->save($alliance);
					foreach ($users as $user) {
						$igm = new Rakuun_Intern_IGM('Bewerbung bei '.$meta->name.' angenommen', $user);
						$igm->type = Rakuun_Intern_IGM::TYPE_META;
						$igm->setSenderName(Rakuun_Intern_IGM::SENDER_META);
						$igm->setText(
							'Hallo '.$user->name.',<br />'.
							'['.Rakuun_User_Manager::getCurrentUser()->alliance->tag.'] '.Rakuun_User_Manager::getCurrentUser()->alliance->name.' hat eure Metabewerbung angenommen.'
						);
						$igm->send();
					}
					Rakuun_DB_Containers::getMetasApplicationsContainer()->delete(array('conditions' => array(array('alliance = ?', $alliance))));
				break;
				case self::ACTION_NOTHING:
					//do nothing
				break;
			}
		}
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
}

?>