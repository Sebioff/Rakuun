<?php

class Rakuun_Intern_Module_Meta extends Rakuun_Intern_Module_Meta_Common {
	public function __construct($name) {
		parent::__construct($name);
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->addSubmodule(new Rakuun_Intern_Module_Meta_Polls('polls'));
		if ($user && Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS)) {
			$this->addSubmodule(new Rakuun_Intern_Module_Meta_Applications('applications'));
			$this->addSubmodule(new Rakuun_Intern_Module_Meta_Edit('edit'));
			$this->addSubmodule(new Rakuun_Intern_Module_Meta_Build('build'));
		}
		if ($user && Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_STATISTICS))
			$this->addSubmodule(new Rakuun_Intern_Module_Meta_Statistics('statistics'));
	}
	
	public function init() {
		parent::init();
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/meta.tpl');
		
		if ($this->getUser()->alliance->meta != null)
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Meta_Profile_Own('profile'));
		else
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Meta_Profile_None('profile'));
	}
	
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return (isset($user->alliance) && (isset($user->alliance->meta) || Rakuun_Intern_Alliance_Security::get()->isInGroup($user, Rakuun_Intern_Alliance_Security::GROUP_LEADERS)));
	}
}
?>