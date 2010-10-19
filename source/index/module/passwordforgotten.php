<?php

class Rakuun_Index_Module_PasswordForgotten extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Passwort vergessen?');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/passwordforgotten.tpl');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('passwordforgotten', new Rakuun_Index_Panel_PasswordForgotten('passwordforgotten'), 'Neues Passwort anfordern'));
	}
}

?>