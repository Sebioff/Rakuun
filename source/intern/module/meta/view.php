<?php

class Rakuun_Intern_Module_Meta_View extends Rakuun_Intern_Module {
	private $id = 0;
	
	public function init() {
		parent::init();
		$this->id = (int)$this->getParam('meta');
		if (!$this->id > 0) {
			$this->contentPanel->addError('No meta id given');
			return;
		}
		$this->contentPanel->setTemplate(dirname(__FILE__).'/view.tpl');
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Meta_Profile_Other('view', $this->id));
	}
}
?>