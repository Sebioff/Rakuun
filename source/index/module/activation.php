<?php

class Rakuun_Index_Module_Activation extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Account Aktivierung');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/activation.tpl');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('activation', new Rakuun_Index_Panel_Activation('activation'), 'Aktivierung'));
	}
}

?>