<?php

class Rakuun_Intern_GUI_Panel_Imprint extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/imprint.tpl');
	}
}

?>