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

class Rakuun_Intern_Module_Multihunting extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Multihunting');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/multihunting.tpl');

		$param = $this->getParam('user');
		$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($param);
		$users = Rakuun_DB_Containers::getUserContainer();
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('search', new Rakuun_Intern_GUI_Panel_Multihunting_Search('search', 'Suchen'), 'Suchen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('multiscore', new Rakuun_Intern_GUI_Panel_Multihunting_Multiscore('multiscore', $users, 'Multiscore'), 'Multiscore'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('multiaction', new Rakuun_Intern_GUI_Panel_Multihunting_MultiActionLog('multiaction', $user, 'Multiaktivitäten'), 'Multiaktivitäten'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('activity', new Rakuun_Intern_GUI_Panel_Multihunting_ActivityLog('activity', $user, 'Aktivitätslog'), 'Aktivitätslog'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('ressource', new Rakuun_Intern_GUI_Panel_Multihunting_RessourceLog('ressource', $user, 'Ressourcen-Transfer'), 'Ressourcen-Transfer'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('userdata', new Rakuun_Intern_GUI_Panel_Multihunting_UserdataLog('userdata', $user, 'Userdaten'), 'Userdaten'));
	}
	
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user && Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_MULTIHUNTING));
	}
}

?>