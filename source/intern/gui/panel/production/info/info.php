<?php

class Rakuun_Intern_GUI_Panel_Production_Info extends Rakuun_GUI_Panel_Box {
	private $productionItem = null;
	
	public function __construct($name, Rakuun_Intern_Production_Base $productionItem) {
		parent::__construct($name, null, $productionItem->getName());
		
		$this->productionItem = $productionItem;
		$this->addClasses('rakuun_production_info_box');
	}
	
	public function init() {
		parent::init();
		
		if ($this->getProductionItem() instanceof Rakuun_Intern_Production_Building_RessourceProducer) {
			$this->contentPanel->addPanel($production = new GUI_Panel_Table('production', 'Produktionsrate'));
			$production->setAttribute('summary', 'Produktionsrate');
			$production->addHeader(array('Stufe', 'Produktion / 5 Minuten'));
			$startLevel = max($this->getProductionItem()->getLevel() - 5, 1);
			$endLevel = $this->getProductionItem()->getLevel() + 5;
			$productionTime = time() - 60 * 5;
			for ($i = $startLevel; $i <= $endLevel; $i++) {
				if ($this->getProductionItem()->getBaseIronProduction() > 0)
					$production->addLine(array($i, GUI_Panel_Number::formatNumber($this->getProductionItem()->getProducedIron($productionTime, $i * Rakuun_Intern_Production_Building_RessourceProducer::WORKERS_PER_LEVEL, $i))));
				else if ($this->getProductionItem()->getBaseBerylliumProduction() > 0)
					$production->addLine(array($i, GUI_Panel_Number::formatNumber($this->getProductionItem()->getProducedBeryllium($productionTime, $i * Rakuun_Intern_Production_Building_RessourceProducer::WORKERS_PER_LEVEL, $i))));
				else if ($this->getProductionItem()->getBaseEnergyProduction() > 0)
					$production->addLine(array($i, GUI_Panel_Number::formatNumber($this->getProductionItem()->getProducedEnergy($productionTime, $i * Rakuun_Intern_Production_Building_RessourceProducer::WORKERS_PER_LEVEL, $i))));
				else if ($this->getProductionItem()->getBasePeopleProduction() > 0)
					$production->addLine(array($i, GUI_Panel_Number::formatNumber($this->getProductionItem()->getProducedPeople($productionTime, $i * Rakuun_Intern_Production_Building_RessourceProducer::WORKERS_PER_LEVEL, $i))));
			}
			$this->contentPanel->setTemplate(dirname(__FILE__).'/ressourceproducer.tpl');
		}
		else if ($this->getProductionItem() instanceof Rakuun_Intern_Production_CityItem) {
			$this->contentPanel->setTemplate(dirname(__FILE__).'/cityitem.tpl');
		}
		else if ($this->getProductionItem() instanceof Rakuun_Intern_Production_Unit) {
			$this->contentPanel->addPanel($costs = new GUI_Panel_Table('costs', 'Kosten'));
			$costs->setAttribute('summary', 'Kostentabelle');
			$costs->addHeader(array('Eisen', 'Beryllium', 'Energie', 'Leute', 'Zeit'));
			$costs->addLine(
				array(
					GUI_Panel_Number::formatNumber($this->getProductionItem()->getBaseIronCosts()),
					GUI_Panel_Number::formatNumber($this->getProductionItem()->getBaseBerylliumCosts()),
					GUI_Panel_Number::formatNumber($this->getProductionItem()->getBaseEnergyCosts()),
					GUI_Panel_Number::formatNumber($this->getProductionItem()->getBasePeopleCosts()),
					Rakuun_Date::formatCountDown($this->getProductionItem()->getBaseTimeCosts())
				)
			);
			$this->contentPanel->setTemplate(dirname(__FILE__).'/unit.tpl');
		}
		
		if ($this->getProductionItem() instanceof Rakuun_Intern_Production_CityItem) {
			$this->contentPanel->addPanel($costs = new GUI_Panel_Table('costs', 'Kosten'));
			$costs->setAttribute('summary', 'Kostentabelle');
			$costs->addHeader(array('Stufe', 'Eisen', 'Beryllium', 'Energie', 'Leute', 'Zeit'));
			$startLevel = max($this->getProductionItem()->getLevel() - 5, 1);
			$endLevel = $this->getProductionItem()->getLevel() + 5;
			for ($i = $startLevel; $i <= $endLevel; $i++) {
				$costs->addLine(
					array(
						$i,
						GUI_Panel_Number::formatNumber($this->getProductionItem()->getIronCostsForLevel($i)),
						GUI_Panel_Number::formatNumber($this->getProductionItem()->getBerylliumCostsForLevel($i)),
						GUI_Panel_Number::formatNumber($this->getProductionItem()->getEnergyCostsForLevel($i)),
						GUI_Panel_Number::formatNumber($this->getProductionItem()->getPeopleCostsForLevel($i)),
						Rakuun_Date::formatCountDown($this->getProductionItem()->getTimeCosts($i))
					)
				);
			}
		}
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_Intern_Production_Base
	 */
	public function getProductionItem() {
		return $this->productionItem;
	}
}

?>