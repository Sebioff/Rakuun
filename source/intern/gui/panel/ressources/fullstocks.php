<?php

class Rakuun_Intern_GUI_Panel_Ressources_FullStocks extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/fullstocks.tpl');
		
		$this->addPanel($ressourceProductionTable = new GUI_Panel_Table('ressource_fullstocks'));
		$ressourceProductionTable->addHeader(array('Eisen', 'Beryllium', 'Energie', 'Leute'));
		
		$ironPerSecond = Rakuun_Intern_Production_Factory::getBuilding('ironmine')->getProducedIron(time() - 1);
		if ($ironPerSecond > 0) {
			$ironCapacityLeft = Rakuun_User_Manager::getCurrentUser()->ressources->getCapacityIron() - Rakuun_User_Manager::getCurrentUser()->ressources->iron - Rakuun_User_Manager::getCurrentUser()->ressources->producedIron - Rakuun_Intern_Production_Factory::getBuilding('ironmine')->getProducedIron();
			$timeTillIronFull = $ironCapacityLeft / $ironPerSecond;
			$this->addPanel($countDown = new Rakuun_GUI_Panel_CountDown('ironstock_full', time() + $timeTillIronFull, 'Lager voll.'));
			$countDown->enableHoverInfo(true);
		}
		else {
			$this->addPanel(new GUI_Panel_Text('ironstock_full', '&infin;'));
		}
		
		$berylliumPerSecond = Rakuun_Intern_Production_Factory::getBuilding('berylliummine')->getProducedBeryllium(time() - 1);
		if ($berylliumPerSecond > 0) {
			$berylliumCapacityLeft = Rakuun_User_Manager::getCurrentUser()->ressources->getCapacityBeryllium() - Rakuun_User_Manager::getCurrentUser()->ressources->beryllium - Rakuun_User_Manager::getCurrentUser()->ressources->producedBeryllium - Rakuun_Intern_Production_Factory::getBuilding('berylliummine')->getProducedBeryllium();
			$timeTillBerylliumFull = $berylliumCapacityLeft / $berylliumPerSecond;
			$this->addPanel($countDown = new Rakuun_GUI_Panel_CountDown('berylliumstock_full', time() + $timeTillBerylliumFull, 'Lager voll.'));
			$countDown->enableHoverInfo(true);
		}
		else {
			$this->addPanel(new GUI_Panel_Text('berylliumstock_full', '&infin;'));
		}
		
		$energyPerSecond = Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')->getProducedEnergy(time() - 1);
		if ($energyPerSecond > 0) {
			$energyCapacityLeft = Rakuun_User_Manager::getCurrentUser()->ressources->getCapacityEnergy() - Rakuun_User_Manager::getCurrentUser()->ressources->energy - Rakuun_User_Manager::getCurrentUser()->ressources->producedEnergy - Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')->getProducedEnergy();
			$timeTillEnergyFull = $energyCapacityLeft / $energyPerSecond;
			$this->addPanel($countDown = new Rakuun_GUI_Panel_CountDown('energystock_full', time() + $timeTillEnergyFull, 'Lager voll.'));
			$countDown->enableHoverInfo(true);
		}
		else {
			$this->addPanel(new GUI_Panel_Text('energystock_full', '&infin;'));
		}
		
		$peoplePerSecond = Rakuun_Intern_Production_Factory::getBuilding('clonomat')->getProducedPeople(time() - 1);
		if ($peoplePerSecond > 0) {
			$peopleCapacityLeft = Rakuun_User_Manager::getCurrentUser()->ressources->getCapacityPeople() - Rakuun_User_Manager::getCurrentUser()->ressources->people - Rakuun_User_Manager::getCurrentUser()->ressources->producedPeople - Rakuun_Intern_Production_Factory::getBuilding('clonomat')->getProducedPeople();
			$timeTillPeopleFull = $peopleCapacityLeft / $peoplePerSecond;
			$this->addPanel($countDown = new Rakuun_GUI_Panel_CountDown('peoplestock_full', time() + $timeTillPeopleFull, 'Lager voll.'));
			$countDown->enableHoverInfo(true);
		}
		else {
			$this->addPanel(new GUI_Panel_Text('peoplestock_full', '&infin;'));
		}
	}
	
	public function afterInit() {
		parent::afterInit();
		
		/*
		 * Needs to be done in afterInit because in addLine the panels get rendered (--> __toString()).
		 * The correct panel IDs aren't known until afterInit.
		 */
		$this->ressourceFullstocks->addLine(
			array(
				$this->ironstockFull,
				$this->berylliumstockFull,
				$this->energystockFull,
				$this->peoplestockFull
			)
		);
	}
}

?>