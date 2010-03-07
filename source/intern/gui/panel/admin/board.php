<?php

class Rakuun_Intern_GUI_Panel_Admin_Board extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/board.tpl');
		
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board('board'), 'Admin Forum');
	}	
}

?>