<?php

class Rakuun_Intern_Module_Alliance_View extends Rakuun_Intern_Module {
	private $id = 0;
	
	public function init() {
		parent::init();
		$this->id = (int)$this->getParam('alliance');
		if (!$this->id > 0) {
			$this->contentPanel->addError('No alliance id given');
			return;
		}
		$this->contentPanel->setTemplate(dirname(__FILE__).'/view.tpl');
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Alliance_Profile_Other('view', $this->id));
	}
}
?>