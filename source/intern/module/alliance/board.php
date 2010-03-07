<?php

class Rakuun_Intern_Module_Alliance_Board extends Rakuun_Intern_Module_Alliance_Navigation implements Scriptlet_Privileged {
	public function init() {
		parent::init();

		$this->setPageTitle('Forum - ['.$this->getUser()->alliance->tag.'] '.$this->getUser()->alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/board.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('board', new Rakuun_Intern_GUI_Panel_Alliance_Board('Forum'), 'Allianz Forum'));
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return (isset($this->getUser()->alliance));
	}
}

?>