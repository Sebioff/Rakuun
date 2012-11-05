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
 * Panel to add VIPs
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_Staff extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/staff.tpl');
		
		$this->addPanel($user = new Rakuun_GUI_Control_UserSelect('user', null, 'User'));
		$user->addValidator(new GUI_Validator_Mandatory());
		
		$this->addPanel($groups = new GUI_Control_CheckBoxList('groups', 'Gruppen'));
		foreach (Rakuun_GameSecurity::get()->getVIPGroups() as $group) {
			$groups->addItem($group->name, $group->groupIdentifier);
		}
		
		$this->addPanel(new GUI_Control_SubmitButton('register', 'User als VIP eintragen'));
	}
	
	public function onRegister() {
		if ($this->hasErrors())
			return;
		
		$user = $this->user->getUser();
		$admin = Rakuun_User_Manager::getCurrentUser();
		$msgGroups = array();
		DB_Connection::get()->beginTransaction();
		Rakuun_GameSecurity::get()->removeFromAllGroups($user);
		foreach ($this->groups->getSelectedItems() as $item) {
			$group = Rakuun_GameSecurity::get()->getGroup($item->getValue());
			Rakuun_GameSecurity::get()->addToGroup($user, $group);
			$msgGroups[$group->groupIdentifier] = $group->name;
		}
		DB_Connection::get()->commit();
		
		// send information message to the user
		$igm = new Rakuun_Intern_IGM('Eintragung!', $user, '');
		$igm->setSender($admin);
		$message = 'Du bist von @'.$admin->nameUncolored.'@ in folgende Gruppen eingetragen worden:<br/>'.implode('<br/>', $msgGroups);
		if (isset($msgGroups[Rakuun_GameSecurity::GROUP_DONORS]) || isset($msgGroups[Rakuun_GameSecurity::GROUP_SPONSORS])) {
			$message .= '<br/>Vielen Dank für deine Spende! Du hast neue Funktionen erhalten.';
			$message .= '<br/><a href="'.App::get()->getInternModule()->getSubmodule('profile')->getURL().'">Profil</a>';
		}
		$igm->setText($message);
		$igm->send();
	}
}

?>