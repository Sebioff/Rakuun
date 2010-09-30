<?php

/**
 * A Module for giving introductions to the users, to win the Game.
 * @author dr.dent
 */
class Rakuun_Intern_Module_Guide extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
			
		$this->setPageTitle('Anleitung');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/guide.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('guide', new Rakuun_Intern_GUI_Panel_Guide('guide', 'Anleitung')));
	}
}

?>