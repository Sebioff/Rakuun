<?php

/**
 * shows the rules in this game
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Rules extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/rules.tpl');
	}
}

?>