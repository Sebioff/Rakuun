<?php

class Rakuun_Index_Module_Info extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Infos');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/info.tpl');
		$this->setMetaTag('description', 'Allgemeine Informationen über das kostenlose Browsergame Rakuun.');
		$this->setMetaTag('keywords', 'rakuun, features, informationen, infos');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('info', new Rakuun_Index_Panel_Info('content'), 'Funktionen'));
	}
}

?>