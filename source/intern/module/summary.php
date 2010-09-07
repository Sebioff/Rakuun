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
		$this->contentPanel->addPanel(
			new Rakuun_GUI_Panel_Box('lostunits', new Rakuun_Intern_GUI_Panel_Statistics_User_LostUnits('lostunits'), 'Verlorene Einheiten')
		);
		$this->contentPanel->addPanel(
			new Rakuun_GUI_Panel_Box('destroyedunits', new Rakuun_Intern_GUI_Panel_Statistics_User_DestroyedUnits('destroyedunits'), 'Vernichtete Einheiten')
		);
		$this->contentPanel->addPanel(
			new Rakuun_GUI_Panel_Box('lostbuildings', new Rakuun_Intern_GUI_Panel_Statistics_User_LostBuildings('lostbuildings'), 'Verlorene Gebäude')
		);
		$this->contentPanel->addPanel(
			$ressourcesStats = new Rakuun_GUI_Panel_Box('ressources', new Rakuun_Intern_GUI_Panel_Statistics_User_Ressources('ressources'), 'Ressourcen')
		);
		$ressourcesStats->addClasses('rakuun_box_summary_ressources');
		$this->contentPanel->addPanel(
			$fightsStats = new Rakuun_GUI_Panel_Box('fights', new Rakuun_Intern_GUI_Panel_Statistics_User_Fights('fights'), 'Kämpfe')
		);
		$fightsStats->addClasses('rakuun_box_summary_fights');
		$this->contentPanel->addPanel(
			new Rakuun_GUI_Panel_Box('destroyedbuildings', new Rakuun_Intern_GUI_Panel_Statistics_User_DestroyedBuildings('destroyedbuildings'), 'Vernichtete Gebäude')
		);
		$this->contentPanel->addPanel(
			new Rakuun_GUI_Panel_Box('buildingevents', new Rakuun_Intern_GUI_Panel_Statistics_User_BuildingEvents('buildingevents'), 'Gebäude')
		);
	}
}
?>