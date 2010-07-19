<?php

class Rakuun_Intern_GUI_Panel_Ressources_Capacity extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/capacity.tpl');
		
		$this->addPanel($ressourceProductionTable = new GUI_Panel_Table('ressource_capacity'));
		$ressourceProductionTable->addHeader(array('', 'Eisen', 'Beryllium', 'Energie', 'Leute'));
		
		$ressourceProductionTable->addLine(
			array(
				'Lagerkapazität',
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getCapacityIron()),
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getCapacityBeryllium()),
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getCapacityEnergy()),
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getCapacityPeople())
			)
		);
		
		$ressourceProductionTable->addLine(
			array(
				new Rakuun_GUI_Panel_Info('save_capacity', 'Sichere Kapazität', 'Die sichere Kapazität gibt an, bis zu welcher Grenze Ressourcen gestohlen werden können.<br/>Der Wert steigt um '.GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Building_Store::SAVE_CAPACITY_RAISE_PER_WEEK * RAKUUN_STORE_CAPACITY_SAVE_MULTIPLIER).' pro Woche.'),
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getSaveCapacityIron()),
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getSaveCapacityBeryllium()),
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getSaveCapacityEnergy()),
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getSaveCapacityPeople())
			)
		);
	}
}

?>