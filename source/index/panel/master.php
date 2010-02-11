<?php

class Rakuun_Index_Panel_Master extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/master.tpl');
		
		$this->addPanel($key = new GUI_Control_PasswordBox('key', null, 'Key'));
		$key->addValidator(new GUI_Validator_Mandatory());
		$key->setFocus();
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'OK'));
	}
	
	public function onSubmit() {
		if (md5($this->key->getValue()) == MASTERKEY)
			setcookie('mk_cookie', $this->key->getValue(), time() + 60 * 60 * 24 * 356 * 5);
	}
}

?>