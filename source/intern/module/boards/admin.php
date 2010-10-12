<?php

class Rakuun_Intern_Module_Boards_Admin extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Admin');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/board.tpl');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('box', new Rakuun_Intern_GUI_Panel_Board_Admin('admin'), 'Admin'));
	}
}
?>