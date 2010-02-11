<?php

class Rakuun_Intern_Module_Alliance_Kick extends Rakuun_Intern_Module_Alliance_Navigation implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Member kicken - ['.$this->getUser()->alliance->tag.'] '.$this->getUser()->alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/kick.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('kick', new Rakuun_Intern_GUI_Panel_Alliance_Kick('kick'), 'Allianz Member kicken'));
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_KICKING);
	}
}

?>