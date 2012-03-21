<?php

class Rakuun_Intern_Module_ReportedMessages extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Gemeldete Nachrichten');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/reportedmessages.tpl');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('reportedmessages', new Rakuun_Intern_GUI_Panel_Admin_ReportedMessages('reportedmessages', 'Gemeldete Nachrichten'), 'Gemeldete Nachrichten'));
	}
	
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user && Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_REPORTEDMESSAGES));
	}
}

?>