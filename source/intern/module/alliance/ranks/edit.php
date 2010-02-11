<?php

class Rakuun_Intern_Module_Alliance_Ranks_Edit extends Rakuun_Intern_Module_Alliance_Navigation {
	public function __construct($name) {
		parent::__construct($name);
	}
	
	public function init() {
		parent::init();

		$this->setPageTitle('Ränge - ['.$this->getUser()->alliance->tag.'] '.$this->getUser()->alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/edit.tpl');
		
		$rank = Rakuun_Intern_Alliance_Security::get()->getContainerGroups()->selectByPK($this->getParam('rank'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('edit_rank', new Rakuun_Intern_GUI_Panel_Alliance_Ranks_Edit('edit_rank', $rank), 'Rang bearbeiten'));
	}
}

?>