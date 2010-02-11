<?php

class Rakuun_Index_Module_Master extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Master');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/master.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('master', new Rakuun_Index_Panel_Master('master')));
	}
}

?>