<?php

class Rakuun_Intern_GUI_Panel_Techtree_Category extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/category.tpl');
	}
}

?>