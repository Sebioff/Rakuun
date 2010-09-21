<?php

class Rakuun_Intern_Module_Multihunting extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Multihunting');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/multihunting.tpl');

		$param = $this->getParam('user');
		$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($param);
		
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