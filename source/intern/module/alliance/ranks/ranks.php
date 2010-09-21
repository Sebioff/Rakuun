<?php

class Rakuun_Intern_Module_Alliance_Ranks extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Ranks_Edit('edit'));
	}
	
	public function init() {
		parent::init();

		$this->setPageTitle('Ränge - ['.$this->getUser()->alliance->tag.'] '.$this->getUser()->alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/ranks.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('ranks', new Rakuun_Intern_GUI_Panel_Alliance_Ranks_View('ranks'), 'Ränge'));
		$rank = Rakuun_Intern_Alliance_Security::get()->getContainerGroups()->selectByPK($this->getParam('rank'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('new_rank', new Rakuun_Intern_GUI_Panel_Alliance_Ranks_Edit('new_rank', $rank), 'Neuer Rang'));
	}
	
	// OVERRIDES / IMPLEMENTS
	public function checkPrivileges() {
		return Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_RANKS);
	}
}

?>