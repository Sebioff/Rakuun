<?php

class Rakuun_Index_Module_Register extends Rakuun_Index_Module {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setRouteName('scifi-browsergame-anmeldung');
	}
	
	public function init() {
		parent::init();
		
		$this->setPageTitle('Anmeldung');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/register.tpl');
		$this->setMetaTag('description', 'Melde dich jetzt bei dem kostenlosen SciFi-Browsergame Rakuun an und kämpfe mit um die Erfüllung des Spielziels: die Alleinherrschaft über Rakuun.');
		$this->setMetaTag('keywords', 'browsergame, scifi, anmeldung, registrierung');
		
		$registerPanel = new Rakuun_GUI_Panel_Box('register', new Rakuun_Index_Panel_Register('content'), 'Jetzt anmelden!');
		$this->contentPanel->addPanel($registerPanel);
	}
}

?>