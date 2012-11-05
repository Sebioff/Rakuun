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

class Rakuun_Intern_GUI_Panel_Alliance_Ranks_Edit extends GUI_Panel {
	private $rank = null;
	
	public function __construct($name, DB_Record $rank = null, $title = '') {
		parent::__construct($name, $title);
		
		if ($rank === null) {
			$rank = new DB_Record();
			$rank->alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		}
		$this->rank = $rank;
	}
	
	public function init() {
		parent::init();
		
		if ($this->rank->name)
			$this->getParent()->setTitle('Rang "'.Text::escapeHTML($this->rank->name).'"');
		
		$this->setTemplate(dirname(__FILE__).'/edit.tpl');
		$this->addPanel($name = new GUI_Control_TextBox('name', $this->rank->name, 'Name'));
		$name->addValidator(new GUI_Validator_Mandatory());
		$name->addValidator(new GUI_Validator_RangeLength(2, 25));
		$securityContainer = Rakuun_Intern_Alliance_Security::get();
		$this->addPanel($memberList = new GUI_Control_CheckBoxList('members'));
		$memberList->addClasses('alliance_userlist');
		foreach (Rakuun_User_Manager::getCurrentUser()->alliance->members as $member) {
			$hasPrivilege = $securityContainer->isInGroup($member, $this->rank);
			$memberList->addItem($member->name, $member->getPK(), $hasPrivilege);
		}
		if ($this->rank->groupIdentifier != Rakuun_Intern_Alliance_Security::GROUP_LEADERS) {
			$this->addPanel($privilegeList = new GUI_Control_CheckBoxList('privileges'));
			$privilegeList->addClasses('alliance_privilegelist');
			foreach ($securityContainer->getDefinedPrivileges() as $privilege) {
				$hasPrivilege = $securityContainer->groupHasPrivilege($this->rank, $privilege);
				$privilegeInfo = new Rakuun_GUI_Panel_Info($privilege, $securityContainer->getPrivilegeName($privilege), $securityContainer->getPrivilegeDescription($privilege));
				$privilegeList->addPanel($privilegeInfo);
				$privilegeList->addItem($privilegeInfo, $privilege, $hasPrivilege);
			}
		}
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'speichern'));
	}
	
	public function onSubmit() {
		if ($this->rank->groupIdentifier == Rakuun_Intern_Alliance_Security::GROUP_LEADERS
			&& !Rakuun_Intern_Alliance_Security::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::GROUP_LEADERS)
		)
			return;
		
		if ($this->hasErrors())
			return;

		DB_Connection::get()->beginTransaction();
		// save group
		$this->rank->name = $this->name;
		Rakuun_Intern_Alliance_Security::get()->getContainerGroups()->save($this->rank);
		// save group/user assoc
		$groupsUsersAssocContainer = Rakuun_Intern_Alliance_Security::get()->getContainerGroupsUsersAssoc();
		$groupsUsersAssocContainer->deleteByUserGroup($this->rank);
		$rankHasUsers = false;
		foreach ($this->members->getItems() as $memberCheckbox) {
			if ($memberCheckbox->getSelected()) {
				if (array_search($memberCheckbox->getValue(), Rakuun_User_Manager::getCurrentUser()->alliance->members) !== false) {
					$groupUsersAssoc = new DB_Record();
					$groupUsersAssoc->userGroup = $this->rank;
					$groupUsersAssoc->user = $memberCheckbox->getValue();
					$groupsUsersAssocContainer->save($groupUsersAssoc);
					$rankHasUsers = true;
				}
			}
		}
		// make sure there is a leader
		if ($this->rank->groupIdentifier == Rakuun_Intern_Alliance_Security::GROUP_LEADERS && !$rankHasUsers) {
			DB_Connection::get()->rollback();
			$this->addError('Es muss mindestens einen Leiter geben');
			return;
		}
		// save privileges
		if ($this->rank->groupIdentifier != Rakuun_Intern_Alliance_Security::GROUP_LEADERS) {
			$privilegesContainer = Rakuun_Intern_Alliance_Security::get()->getContainerPrivileges();
			$privilegesContainer->deleteByUserGroup($this->rank);
			$definedPrivileges = Rakuun_Intern_Alliance_Security::get()->getDefinedPrivileges();
			foreach ($this->privileges->getItems() as $privilegeCheckbox) {
				if ($privilegeCheckbox->getSelected()) {
					if (array_search($privilegeCheckbox->getValue(), $definedPrivileges) !== false) {
						$privilege = new DB_Record();
						$privilege->userGroup = $this->rank;
						$privilege->privilege = $privilegeCheckbox->getValue();
						$privilege->value = true;
						$privilegesContainer->save($privilege);
					}
				}
			}
		}
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
}

?>