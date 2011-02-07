<?php

class Rakuun_Intern_Module_Ressources extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Ressourcen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/ressources.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('ressource_production', new Rakuun_Intern_GUI_Panel_Ressources_Production('ressource_production'), 'Ressourcenproduktion'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('ressource_capacity', new Rakuun_Intern_GUI_Panel_Ressources_Capacity('ressource_capacity'), 'Lagerkapazitäten'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('ressource_fullstocks', new Rakuun_Intern_GUI_Panel_Ressources_FullStocks('ressource_fullstocks'), 'Lager voll in...'));
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_ironmine', Rakuun_Intern_Production_Factory::getBuilding('ironmine')));
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_berylliummine', Rakuun_Intern_Production_Factory::getBuilding('berylliummine')));
		if (Rakuun_Intern_Production_Factory::getBuilding('clonomat')->getLevel() > 0)
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_clonomat', Rakuun_Intern_Production_Factory::getBuilding('clonomat')));
		if (Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')->getLevel() > 0)
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Production_Workers('workers_hydropower_plant', Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')));
	}
}

?>