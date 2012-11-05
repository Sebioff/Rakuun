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
 * Panel to Change the Rights of a Teammember
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_Privileges extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/privileges.tpl');
		
		// get users of the group "TEAM" into the DropDownBox
		$teammembers = array();
		foreach (Rakuun_GameSecurity::get()->getGroupUsers(Rakuun_GameSecurity::GROUP_TEAM) as $teammember)
			$teammembers[$teammember->getPK()] = $teammember->nameUncolored;
		$this->addPanel(new GUI_Control_DropDownBox('teammember', $teammembers));
		
		$this->addPanel($groups = new GUI_Control_CheckBoxList('groups', 'Gruppen'));
		foreach (Rakuun_TeamSecurity::get()->getGroups() as $group) {
			$groups->addItem($group->name, $group->groupIdentifier);
		}
		
		$this->addPanel(new GUI_Control_SubmitButton('update', 'Rechte ändern'));
	}
	
	public function onUpdate() {
		if ($this->hasErrors())
			return;
		
		$teammember = Rakuun_DB_Containers::getUserContainer()->selectByPK($this->teammember->getKey());
		$msgGroups = '<br />';
		$admin = Rakuun_User_Manager::getCurrentUser();
		DB_Connection::get()->beginTransaction();
		Rakuun_TeamSecurity::get()->removeFromAllGroups($teammember);
		foreach ($this->groups->getSelectedItems() as $item) {
			$right = Rakuun_TeamSecurity::get()->getGroup($item->getValue());
			Rakuun_TeamSecurity::get()->addToGroup($teammember, $right);
			$msgGroups .= $right->name.'<br />';
		}
		DB_Connection::get()->commit();
		
		// send information message to the user
		$igm = new Rakuun_Intern_IGM('Rechte geändert!', $teammember, '');
		$igm->setSender($admin);
		$message = 'Deine Rechte als Teammitglied wurden von @'.$admin->nameUncolored.'@ geändert. Du bist nun in folgenden Gruppen:'.$msgGroups;
		$igm->setText($message);
		$igm->send();
	}
}

?>