<?php

/**
 * Displays a summary of all kind of items an user can build
 */
class Rakuun_Intern_Module_Summary extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Zusammenfassung');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/summary.tpl');
		
		$this->contentPanel->addPanel(
			new Rakuun_GUI_Panel_Box('buildingsbox', new Rakuun_Intern_GUI_Panel_Summary_Buildings('buildings'), 'Gebäude')
		);
		$this->contentPanel->addPanel(
			new Rakuun_GUI_Panel_Box('technologiesbox', new Rakuun_Intern_GUI_Panel_Summary_Technologies('technologies'), 'Forschungen')
		);
		$this->contentPanel->addPanel(
			new Rakuun_GUI_Panel_Box('unitsbox', new Rakuun_Intern_GUI_Panel_Summary_Units('units'), 'Einheiten')
		);
	}
}
?>