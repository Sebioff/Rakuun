<?php

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