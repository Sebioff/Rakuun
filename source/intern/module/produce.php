<?php

class Rakuun_Intern_Module_Produce extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Einheiten produzieren');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/produce.tpl');
		
		$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_Units('wip', new Rakuun_Intern_Production_Producer_Units(Rakuun_DB_Containers::getUnitsContainer(), Rakuun_DB_Containers::getUnitsWIPContainer()), 'Momentane Einheitenproduktion');
		$this->contentPanel->addPanel($wipPanel, true);
		
		$canProduce = false;
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($unit->meetsTechnicalRequirements()) {
				$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Unit('produce_'.$unit->getInternalName(), $unit));
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