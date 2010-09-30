<?php

/**
 * show the guide
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Guide extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/guide.tpl');
	}
}

?>