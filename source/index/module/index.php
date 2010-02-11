<?php

class Rakuun_Index_Module_Index extends Rakuun_Index_Module {
	public function onConstruct() {
		parent::onConstruct();
		
		$this->setRouteName('');
	}
	
	public function init() {
		parent::init();
		
		$this->setPageTitle('Runde '.RAKUUN_ROUND_NUMBER);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/index.tpl');
		$this->contentPanel->addPanel($infobox = new Rakuun_GUI_Panel_Box('serverinfo', new Rakuun_Index_Panel_Serverinfo('content'), 'Serverinfo - Runde '.RAKUUN_ROUND_NUMBER));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('register', new Rakuun_Index_Panel_Register('content'), 'Schnellregistrierung'));
	}
}

?>