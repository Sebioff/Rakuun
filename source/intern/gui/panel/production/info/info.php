<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

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
			$startLevel = max($this->getProductionItem()->getLevel(), 1);
			$endLevel = $this->getProductionItem()->getLevel() + 10;
			$productionTime = time() - 60 * 5;
			for ($i = $startLevel; $i <= $endLevel; $i++) {
				if ($this->getProductionItem()->getBaseIronProduction() > 0)
					$production->addLine(array($i, Text::formatNumber($this->getProductionItem()->getProducedIron($productionTime, $i * Rakuun_Intern_Production_Building_RessourceProducer::WORKERS_PER_LEVEL, $i))));
				else if ($this->getProductionItem()->getBaseBerylliumProduction() > 0)
					$production->addLine(array($i, Text::formatNumber($this->getProductionItem()->getProducedBeryllium($productionTime, $i * Rakuun_Intern_Production_Building_RessourceProducer::WORKERS_PER_LEVEL, $i))));
				else if ($this->getProductionItem()->getBaseEnergyProduction() > 0)
					$production->addLine(array($i, Text::formatNumber($this->getProductionItem()->getProducedEnergy($productionTime, $i * Rakuun_Intern_Production_Building_RessourceProducer::WORKERS_PER_LEVEL, $i))));
				else if ($this->getProductionItem()->getBasePeopleProduction() > 0)
					$production->addLine(array($i, Text::formatNumber($this->getProductionItem()->getProducedPeople($productionTime, $i * Rakuun_Intern_Production_Building_RessourceProducer::WORKERS_PER_LEVEL, $i))));
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
					Text::formatNumber($this->getProductionItem()->getBaseIronCosts()),
					Text::formatNumber($this->getProductionItem()->getBaseBerylliumCosts()),
					Text::formatNumber($this->getProductionItem()->getBaseEnergyCosts()),
					Text::formatNumber($this->getProductionItem()->getBasePeopleCosts()),
					Rakuun_Date::formatCountDown($this->getProductionItem()->getBaseTimeCosts())
				)
			);
			$this->contentPanel->setTemplate(dirname(__FILE__).'/unit.tpl');
		}
		
		if ($this->getProductionItem() instanceof Rakuun_Intern_Production_CityItem) {
			$this->contentPanel->addPanel($costs = new GUI_Panel_Table('costs', 'Kosten'));
			$costs->setAttribute('summary', 'Kostentabelle');
			$costs->addHeader(array('Stufe', 'Eisen', 'Beryllium', 'Energie', 'Leute', 'Zeit'));
			$startLevel = max($this->getProductionItem()->getLevel(), 1);
			$endLevel = $this->getProductionItem()->getLevel() + 10;
			if ($this->getProductionItem()->getMaximumLevel() > 0 && $this->getProductionItem()->getMaximumLevel() < $endLevel)
				$endLevel = $this->getProductionItem()->getMaximumLevel();
			for ($i = $startLevel; $i <= $endLevel; $i++) {
				$costs->addLine(
					array(
						$i,
						Text::formatNumber($this->getProductionItem()->getIronCostsForLevel($i)),
						Text::formatNumber($this->getProductionItem()->getBerylliumCostsForLevel($i)),
						Text::formatNumber($this->getProductionItem()->getEnergyCostsForLevel($i)),
						Text::formatNumber($this->getProductionItem()->getPeopleCostsForLevel($i)),
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