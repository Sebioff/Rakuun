<?php

class Rakuun_Index_Panel_Story extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/story.tpl');
	}
}

?>