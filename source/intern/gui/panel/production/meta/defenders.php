<?php

/**
 * A panel displaying costs of a building and allowing to build/remove levels of
 * it.
 */
class Rakuun_Intern_GUI_Panel_Production_Meta_Defenders extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/defenders.tpl');
	}
}

?>