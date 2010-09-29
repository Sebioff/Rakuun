<?php

/**
 * A Module for displaying the rules in this Game
 * @author dr.dent
 */
class Rakuun_Intern_Module_Rules extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
			
		$this->setPageTitle('Regeln');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/rules.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('rules', new Rakuun_Intern_GUI_Panel_Rules('rules', 'Regeln')));
	}
}

?>