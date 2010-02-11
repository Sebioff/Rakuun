<?php

class Rakuun_Intern_GUI_Panel_Ressources_Production extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/production.tpl');
		
		$this->addPanel($ressourceProductionTable = new GUI_Panel_Table('ressource_production'));
		$ressourceProductionTable->addHeader(array('Pro:', 'Eisen', 'Beryllium', 'Energie', 'Leute'));
		
		$ressourceProductionTable->addLine(
			array(
				'5 Minuten',
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('ironmine')->getProducedIron(time() - 5 * 60)),
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('berylliummine')->getProducedBeryllium(time() - 5 * 60)),
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')->getProducedEnergy(time() - 5 * 60)),
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('clonomat')->getProducedPeople(time() - 5 * 60))
			)
		);
		
		$ressourceProductionTable->addLine(
			array(
				'Stunde',
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('ironmine')->getProducedIron(time() - 60 * 60)),
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('berylliummine')->getProducedBeryllium(time() - 60 * 60)),
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')->getProducedEnergy(time() - 60 * 60)),
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('clonomat')->getProducedPeople(time() - 60 * 60))
			)
		);
		
		$ressourceProductionTable->addLine(
			array(
				'Tag',
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('ironmine')->getProducedIron(time() - 24 * 60 * 60)),
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('berylliummine')->getProducedBeryllium(time() - 24 * 60 * 60)),
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')->getProducedEnergy(time() - 24 * 60 * 60)),
				GUI_Panel_Number::formatNumber(Rakuun_Intern_Production_Factory::getBuilding('clonomat')->getProducedPeople(time() - 24 * 60 * 60))
			)
		);
	}
}

?>