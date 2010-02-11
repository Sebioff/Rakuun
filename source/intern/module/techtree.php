<?php

class Rakuun_Intern_Module_Techtree extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Techtree');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/techtree.tpl');

		$items = array();
		foreach (Rakuun_Intern_Production_Factory::getAllBuildings() as $building) {
			$this->contentPanel->addPanel($item = new Rakuun_Intern_GUI_Panel_Techtree_Item('item_'.$building->getInternalName(), $building));
			$items[] = $item;
		}
		$this->contentPanel->params->buildings = $items;
		
		$items = array();
		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies() as $technology) {
			$this->contentPanel->addPanel($item = new Rakuun_Intern_GUI_Panel_Techtree_Item('item_'.$technology->getInternalName(), $technology));
			$items[] = $item;
		}
		$this->contentPanel->params->technologies = $items;
		
		$items = array();
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			$this->contentPanel->addPanel($item = new Rakuun_Intern_GUI_Panel_Techtree_Item('item_'.$unit->getInternalName(), $unit));
			$items[] = $item;
		}
		$this->contentPanel->params->units = $items;
	}
}

?>