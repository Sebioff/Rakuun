<?php

class Rakuun_Intern_GUI_Panel_Map_Legend extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/legend.tpl');
	}
}

?>