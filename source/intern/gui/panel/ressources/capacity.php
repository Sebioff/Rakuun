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
				'Sichere Kapazität',
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getSaveCapacityIron()),
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getSaveCapacityBeryllium()),
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getSaveCapacityEnergy()),
				GUI_Panel_Number::formatNumber(Rakuun_User_Manager::getCurrentUser()->ressources->getSaveCapacityPeople())
			)
		);
	}
}

?>