<?php

class Rakuun_Index_Module_Endscore extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Runden-Endhighscore');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/endscore.tpl');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('userbox', new Rakuun_Intern_GUI_Panel_User_Highscore('userhighscore', Rakuun_DB_Containers_Persistent::getUserContainer()), 'User Highscore'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('alliancebox', new Rakuun_Intern_GUI_Panel_Alliance_Highscore('alliancehighscore', Rakuun_DB_Containers_Persistent::getAlliancesContainer()), 'Allianz Highscore'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('buildingrecords', new Rakuun_Index_Panel_Endscore_BuildingRecords('buildingrecords'), 'Gebäude Rekorde'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('technologyrecords', new Rakuun_Index_Panel_Endscore_TechnologyRecords('technologyrecords'), 'Forschungen Rekorde'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('produced_units', new Rakuun_Index_Panel_Endscore_ProducedUnits('produced_units'), 'Produzierte Einheiten im Verlauf der Runde'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('biggestfights', new Rakuun_Index_Panel_Endscore_BiggestFights('biggestfights'), 'Die 5 größten Schlachten'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('biggestraids', new Rakuun_Index_Panel_Endscore_BiggestRaids('biggestraids'), 'Die 20 größten Ressourcenerbeutungen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('bestfighters', new Rakuun_Index_Panel_Endscore_BestFighters('bestfighters'), 'Die 10 glorreichsten Kämpfer'));
	}
}

?>