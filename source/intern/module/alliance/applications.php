<?php

class Rakuun_Intern_Module_Alliance_Applications extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();

		$this->setPageTitle('Bewerbungen - ['.$this->getUser()->alliance->tag.'] '.$this->getUser()->alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/applications.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('applications', new Rakuun_Intern_GUI_Panel_Alliance_Applications('applications'), 'Bewerbungen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('history', new Rakuun_Intern_GUI_Panel_Alliance_Applications_History('history'), 'Bewerbungs-Historie'));
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_APPLICATIONS);
	}
}

?>