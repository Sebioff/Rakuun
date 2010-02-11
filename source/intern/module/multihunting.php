<?php

class Rakuun_Intern_Module_Multihunting extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Multihunting');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/multihunting.tpl');
		// TODO replace with selected user
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('activity', new Rakuun_Intern_GUI_Panel_Multihunting_ActivityLog('activity', Rakuun_User_Manager::getCurrentUser(), 'Aktivitätslog'), 'Aktivitätslog'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('ressource', new Rakuun_Intern_GUI_Panel_Multihunting_RessourceLog('ressource', Rakuun_User_Manager::getCurrentUser(), 'Ressourcen-Transfer'), 'Ressourcen-Transfer'));
	}
	
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user && Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_MULTIHUNTING));
	}
}

?>