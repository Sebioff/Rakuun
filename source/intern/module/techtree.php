<?php

class Rakuun_Intern_Module_Techtree extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Techtree');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/techtree.tpl');

		$buildingsPanel = new Rakuun_Intern_GUI_Panel_Techtree_Category('buildings');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box_Collapsible('buildings', $buildingsPanel, 'Gebäude'));
		foreach (Rakuun_Intern_Production_Factory::getAllBuildings() as $building) {
			$buildingsPanel->addPanel(new Rakuun_Intern_GUI_Panel_Techtree_Item('item_'.$building->getInternalName(), $building));
		}
		
		$technologiesPanel = new Rakuun_Intern_GUI_Panel_Techtree_Category('technologies');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box_Collapsible('technologies', $technologiesPanel, 'Forschungen'));
		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies() as $technology) {
			$technologiesPanel->addPanel(new Rakuun_Intern_GUI_Panel_Techtree_Item('item_'.$technology->getInternalName(), $technology));
		}
		
		$unitsPanel = new Rakuun_Intern_GUI_Panel_Techtree_Category('units');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box_Collapsible('units', $unitsPanel, 'Einheiten'));
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			$unitsPanel->addPanel(new Rakuun_Intern_GUI_Panel_Techtree_Item('item_'.$unit->getInternalName(), $unit));
		}
	}
}

?>