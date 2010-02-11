<?php

class Rakuun_Intern_GUI_Panel_Meta_Profile_None extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->getModule()->setPageTitle('Meta');
		$this->setTemplate(dirname(__FILE__).'/none.tpl');
		$this->addPanel(new Rakuun_GUI_Panel_Box('found', new Rakuun_Intern_GUI_Panel_Meta_Found('found'), 'Meta gründen'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('search', new Rakuun_Intern_GUI_Panel_Meta_Search('search'), 'Meta suchen'));
	}
}
?>