<?php

class Rakuun_Intern_Module_Boards_Alliance extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Allianz');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/board.tpl');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('box', new Rakuun_Intern_GUI_Panel_Board_Alliance('alliance'), 'Allianz'));
	}
}
?>