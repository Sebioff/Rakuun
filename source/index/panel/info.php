<?php

class Rakuun_Index_Panel_Info extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/info.tpl');
	}
}

?>