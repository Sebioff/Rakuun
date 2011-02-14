<?php

class Rakuun_Intern_GUI_Panel_Reports_DeltaIcon extends GUI_Panel {
	public $delta;
	
	public function __construct($name, $delta, $title = '') {
		parent::__construct($name, $title);
		
		$this->delta = $delta;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/deltaicon.tpl');
	}
}
?>