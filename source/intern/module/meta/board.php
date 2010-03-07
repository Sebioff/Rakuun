<?php

class Rakuun_Intern_Module_Meta_Board extends Rakuun_Intern_Module_Meta_Navigation {
	public function init() {
		parent::init();

		$this->setPageTitle('Forum - '.$this->getUser()->alliance->meta->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/board.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('board', new Rakuun_Intern_GUI_Panel_Meta_Board('Forum'), 'Meta Forum'));
	}
}

?>