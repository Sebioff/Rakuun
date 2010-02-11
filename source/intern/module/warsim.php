<?php

class Rakuun_Intern_Module_Warsim extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('War Simulator');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/warsim.tpl');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('warsimbox', new Rakuun_Intern_GUI_Panel_Warsim_Drawpanel('warsim')));
		//$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Warsim_Drawpanel('warsim'));
	}
}
		
?>