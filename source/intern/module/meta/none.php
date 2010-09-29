<?php

class Rakuun_Intern_Module_Meta_None extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Meta');
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Meta_Profile_None('none'));
	}
	
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return (isset($user->alliance) && (isset($user->alliance->meta) || Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS)));
	}
}
?>