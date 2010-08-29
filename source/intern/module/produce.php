<?php

class Rakuun_Intern_Module_Produce extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Einheiten produzieren');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/produce.tpl');
		$this->addJsRouteReference('js', 'production.js');
		
		$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_Units('wip', new Rakuun_Intern_Production_Producer_Units(Rakuun_DB_Containers::getUnitsContainer(), Rakuun_DB_Containers::getUnitsWIPContainer()), 'Momentane Einheitenproduktion');
		$this->contentPanel->addPanel($wipPanel, true);
		
		$canProduce = false;
		$sortpane = new GUI_Panel_Sortable('sortpane', Rakuun_User_Manager::getCurrentUser(), 'sequence_units');
		$sortpane->setHandle('.head');
		$this->contentPanel->addPanel($sortpane);
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($unit->meetsTechnicalRequirements()) {
				$sortpane->addPanel($itemBox = new Rakuun_GUI_Panel_Box('produce_'.$unit->getInternalName(), new Rakuun_Intern_GUI_Panel_Production_Unit('produce_'.$unit->getInternalName(), $unit)));
				$itemBox->addClasses('production_item_box');
				$canProduce = true;
			}
		}
		if (!$canProduce) {
			$link = new GUI_Control_Link('techtree', 'Vorraussetzungen', App::get()->getInternModule()->getSubmodule('techtree')->getUrl());
			$this->contentPanel->addPanel(new GUI_Panel_Text('information', 'Produktion derzeit nicht möglich - es wurden noch keine '.$link->render().' für eine Einheit erfüllt.'));
		}
	}
}

?>