<?php

class Rakuun_Intern_GUI_Panel_Alliance_Profile_None extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->getModule()->setPageTitle('Allianz');
		$this->setTemplate(dirname(__FILE__).'/none.tpl');
		
		$this->addPanel(new Rakuun_GUI_Panel_Box('search', new Rakuun_Intern_GUI_Panel_Alliance_Search('search'), 'Allianz suchen'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('found', new Rakuun_Intern_GUI_Panel_Alliance_Found('found', Rakuun_Intern_Module_Alliance::FOUNDINGCOSTS_IRON, Rakuun_Intern_Module_Alliance::FOUNDINGCOSTS_BERYLLIUM), 'Allianz gründen'));
	}
}
?>