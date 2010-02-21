<?php

class Rakuun_Intern_Module_Research extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Forschen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/research.tpl');
		$this->addJsRouteReference('js', 'production.js');
		
		$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_CityItems('wip', new Rakuun_Intern_Production_Producer_CityItems(Rakuun_DB_Containers::getTechnologiesContainer(), Rakuun_DB_Containers::getTechnologiesWIPContainer()), 'Momentane Forschung');
		$this->contentPanel->addPanel($wipPanel, true);
		
		$canResearch = false;
		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies() as $technology) {
			if ($technology->meetsTechnicalRequirements() || $technology->getLevel() > 0) {
				$this->contentPanel->addPanel($itemBox = new Rakuun_GUI_Panel_Box('build_'.$technology->getInternalName(), new Rakuun_Intern_GUI_Panel_Production_Research('build_'.$technology->getInternalName(), $technology)));
				$itemBox->addClasses('production_item_box');
				$canResearch = true;
			}
		}
		if (!$canResearch) {
			$link = new GUI_Control_Link('techtree', 'Vorraussetzungen', App::get()->getInternModule()->getSubmodule('techtree')->getUrl());
			$this->contentPanel->addPanel(new GUI_Panel_Text('information', 'Forschen derzeit nicht möglich - es wurden noch keine '.$link->render().' für eine Forschung erfüllt.'));
		}
	}
}

?>