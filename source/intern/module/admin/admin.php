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

class Rakuun_Intern_Module_Admin extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser();
		
		$this->setPageTitle('Administration');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/admin.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('cronjobs', new Rakuun_Intern_GUI_Panel_Admin_Cronjobs('cronjobs'), 'Cronjobs'));
		
		if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_GAMEUPDATE)) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('update', new Rakuun_Intern_GUI_Panel_Admin_Update('update'), 'Spielupdate'));
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('roundcontrol', new Rakuun_Intern_GUI_Panel_Admin_RoundControl('roundcontrol'), 'Rundensteuerung'));
		}
		if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_ADDVIPS)) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('staff', new Rakuun_Intern_GUI_Panel_Admin_Staff('staff'), 'VIPs eintragen'));
		}
		if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_CHANGETEAMPRIVILEGES)) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('privileges', new Rakuun_Intern_GUI_Panel_Admin_Privileges('privileges'), 'Rechte eines Teammember ändern'));
		}
		if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_USERUNLOCK)) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('userunlock', new Rakuun_Intern_GUI_Panel_Admin_User_Unlock('userunlock'), 'User Entsperren'));
		}
		if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_USERLOCK)) {
			$param = $this->getParam('lock');
			$lockuser = Rakuun_DB_Containers::getUserContainer()->selectByPK($param);
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('userlock', new Rakuun_Intern_GUI_Panel_Admin_User_Lock('userlock', $lockuser), 'User Sperren'));
		}
		if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_USEREDIT)) {
			$param = $this->getParam('edit');
			$edituser = Rakuun_DB_Containers::getUserContainer()->selectByPK($param);
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('useredit', new Rakuun_Intern_GUI_Panel_Admin_User_Edit('useredit', $edituser), 'User Bearbeiten'));
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('activateuser', new Rakuun_Intern_GUI_Panel_Admin_User_Activate('activateuser'), 'User aktivieren'));
		}
		if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_CAUTION)) {
			$param = $this->getParam('caution');
			$cautionuser = Rakuun_DB_Containers::getUserContainer()->selectByPK($param);
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('caution', new Rakuun_Intern_GUI_Panel_Admin_User_Caution('caution', $cautionuser), 'User verwarnen'));
		}
		if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_USERDELETE)) {
			$param = $this->getParam('delete');
			$deleteUser = Rakuun_DB_Containers::getUserContainer()->selectByPK($param);
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('userdelete', new Rakuun_Intern_GUI_Panel_Admin_User_Delete('userdelete', $deleteUser), 'User löschen'));
		}
		if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_MAIL)) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('mail', new Rakuun_Intern_GUI_Panel_Admin_Mail('mail'), 'Nachricht an alle Spieler'));
		}
		if (Rakuun_TeamSecurity::get()->isInGroup($user, Rakuun_TeamSecurity::GROUP_DEVELOPER)) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('logs', new Rakuun_Intern_GUI_Panel_Admin_Logs('logs'), 'Logs'));
		}
	}
	
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user && Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_BACKENDACCESS));
	}
}

?>