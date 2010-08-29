<?php

class Rakuun_Intern_Module_Build extends Rakuun_Intern_Module {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->addSubmodule(new Rakuun_Intern_Module_Build_Workers('workers'));
	}
	
	public function init() {
		parent::init();
		
		$this->setPageTitle('Gebäude bauen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/build.tpl');
		$this->addJsRouteReference('js', 'production.js');
		
		$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_CityItems('wip', new Rakuun_Intern_Production_Producer_CityItems(Rakuun_DB_Containers::getBuildingsContainer(), Rakuun_DB_Containers::getBuildingsWIPContainer()), 'Momentaner Bauvorgang');
		$this->contentPanel->addPanel($wipPanel, true);
		
		$sortpane = new GUI_Panel_Sortable('sortpane', Rakuun_User_Manager::getCurrentUser(), 'sequence_buildings');
		$sortpane->setHandle('.head');
		$this->contentPanel->addPanel($sortpane);
		foreach (Rakuun_Intern_Production_Factory::getAllBuildings() as $building) {
			if ($building->meetsTechnicalRequirements() || $building->getLevel() > 0) {
				$sortpane->addPanel($itemBox = new Rakuun_GUI_Panel_Box('build_'.$building->getInternalName(), new Rakuun_Intern_GUI_Panel_Production_Building('build_'.$building->getInternalName(), $building)));
				$itemBox->addClasses('production_item_box');
			}
		}
	}
}

?>