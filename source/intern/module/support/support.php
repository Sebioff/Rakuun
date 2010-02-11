<?php

class Rakuun_Intern_Module_Support extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->addSubmodule(new Rakuun_Intern_Module_Support_Display('display'));
	}
	
	public function init() {
		parent::init();

		$this->contentPanel->setTemplate(dirname(__FILE__).'/support.tpl');
		$this->setPageTitle('Supportcenter');
		
		if (!($supportType = $this->getParam('category')))
			$supportType = Rakuun_Intern_GUI_Panel_Support_Categories::CATEGORY_ANSWERED;
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Support_View('view', $supportType));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Support_Categories('categories', 'Nachrichtenkategorien'));
	}
	
	// OVERRIDES / IMPLEMENTS
	public function checkPrivileges() {
		return Rakuun_TeamSecurity::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Teamsecurity::PRIVILEGE_SUPPORT);
	}
}

?>