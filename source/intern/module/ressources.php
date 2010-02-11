<?php

class Rakuun_Intern_Module_Ressources extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Ressourcen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/ressources.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('ressource_production', new Rakuun_Intern_GUI_Panel_Ressources_Production('ressource_production'), 'Ressourcenproduktion'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('ressource_capacity', new Rakuun_Intern_GUI_Panel_Ressources_Capacity('ressource_capacity'), 'Lagerkapazitäten'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('ressource_fullstocks', new Rakuun_Intern_GUI_Panel_Ressources_FullStocks('ressource_fullstocks'), 'Lager voll in...'));
	}
}

?>