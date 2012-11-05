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

class Rakuun_Intern_GUI_Panel_Warsim_Drawpanel extends GUI_Panel {
	private $panelsForDefenders = array();
	private $panelsForDefendersTechnology = array();
	private $panelsForDefendersBuildings = array();
	private $panelsForAttackers = array();
	private $panelsForAttackersTechnology = array();
	private $fightingSystem = null;
	
	public function init() {
		parent::init();

		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($unit->getAttackValue(1) > 0) {
				$this->addPanel($panel = new GUI_Control_DigitBox('att'.$unit->getInternalName(), $unit->getAmount(), $unit->getNameForAmount(0)));
				$this->panelsForAttackers[$unit->getInternalName()] = $panel;
			}
			
			if ($unit->getDefenseValue(1) > 0) {
				$this->addPanel($panel = new GUI_Control_DigitBox('deff'.$unit->getInternalName(), $unit->getAmount(), $unit->getNameForAmount(0)));
				$this->panelsForDefenders[$unit->getInternalName()] = $panel;
			}
		}
		
		$laser = Rakuun_Intern_Production_Factory::getTechnology('laser');
		$this->addPanel($panel = new GUI_Control_DigitBox('atttech'.$laser->getInternalName(), $laser->getLevel(), $laser->getName(), 0, $laser->getMaximumLevel()));
		$this->panelsForAttackersTechnology[$laser->getInternalName()] = $panel;
		$this->addPanel($panel = new GUI_Control_DigitBox('defftech'.$laser->getInternalName(), $laser->getLevel(), $laser->getName(), 0, $laser->getMaximumLevel()));
		$this->panelsForDefendersTechnology[$laser->getInternalName()] = $panel;
		
		$cityWall = Rakuun_Intern_Production_Factory::getBuilding('city_wall');
		$this->addPanel($panel = new GUI_Control_DigitBox('deffbuild'.$cityWall->getInternalName(), $cityWall->getLevel(), $cityWall->getName(), 0, $cityWall->getMaximumLevel()));
		$this->panelsForDefendersBuildings[$cityWall->getInternalName()] = $panel;
		
		$this->addPanel(new GUI_Control_Submitbutton('calcwarsim', 'Berechnen'));
		$this->setTemplate(dirname(__FILE__).'/drawpanel.tpl');
		
		// set default values from spy report
		if (($spyreport = $this->getModule()->getParam('spyreport')) && !$this->calcwarsim->hasBeenSubmitted()) {
			$report = Rakuun_DB_Containers::getLogSpiesContainer()->selectByPK($spyreport);
			if (Rakuun_Intern_GUI_Panel_Reports_Base::hasPrivilegesToSeeReport($report)) {
				foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
					if ($amount = $report->{Text::underscoreToCamelCase($unit->getInternalName())}) {
						if (isset($this->panelsForAttackers[$unit->getInternalName()]))
							$this->panelsForAttackers[$unit->getInternalName()]->setValue($amount);
						if (isset($this->panelsForDefenders[$unit->getInternalName()]))
							$this->panelsForDefenders[$unit->getInternalName()]->setValue($amount);
					}
					else {
						if (isset($this->panelsForAttackers[$unit->getInternalName()]))
							$this->panelsForAttackers[$unit->getInternalName()]->setValue(0);
						if (isset($this->panelsForDefenders[$unit->getInternalName()]))
							$this->panelsForDefenders[$unit->getInternalName()]->setValue(0);
					}
				}
				
				foreach (Rakuun_Intern_Production_Factory::getAllBuildings() as $building) {
					if ($level = $report->{Text::underscoreToCamelCase($building->getInternalName())}) {
						if (isset($this->panelsForDefendersBuildings[$building->getInternalName()]))
							$this->panelsForDefendersBuildings[$building->getInternalName()]->setValue($level);
					}
					else {
						if (isset($this->panelsForDefendersBuildings[$building->getInternalName()]))
							$this->panelsForDefendersBuildings[$building->getInternalName()]->setValue(0);
					}
				}
			}
			
			$this->addPanel(new GUI_Control_Submitbutton('use_own_for_att', 'Eigene übernehmen'));
			$this->addPanel(new GUI_Control_Submitbutton('use_own_for_deff', 'Eigene übernehmen'));
		}
	}
	
	public function onCalcwarsim() {
		if ($this->hasErrors())
			return;
		
		$this->fightingSystem = new Rakuun_Intern_Fights_System();
		$defenders = new DB_Record();
		foreach ($this->panelsForDefenders as $unitName => $panel) {
			$defenders->{Text::underscoreToCamelCase($unitName)} = $panel->getValue();
		}
		$defenders->fightingSequence = Rakuun_User_Manager::getCurrentUser()->units->fightingSequence;
		$defenderTechnology = new DB_Record();
		foreach ($this->panelsForDefendersTechnology as $technologyName => $panel) {
			$defenderTechnology->{Text::underscoreToCamelCase($technologyName)} = $panel->getValue();
		}
		$defenders->technologies = $defenderTechnology;
		$defenderBuildings = new DB_Record();
		foreach ($this->panelsForDefendersBuildings as $buildingName => $panel) {
			$defenderBuildings->{Text::underscoreToCamelCase($buildingName)} = $panel->getValue();
		}
		$defenders->buildings = $defenderBuildings;
		
		$attackers = new DB_Record();
		foreach ($this->panelsForAttackers as $unitName => $panel) {
			$attackers->{Text::underscoreToCamelCase($unitName)} = $panel->getValue();
		}
		$attackers->fightingSequence = Rakuun_User_Manager::getCurrentUser()->units->attackSequence;
		$attackerTechnology = new DB_Record();
		foreach ($this->panelsForAttackersTechnology as $technologyName => $panel) {
			$attackerTechnology->{Text::underscoreToCamelCase($technologyName)} = $panel->getValue();
		}
		$attackers->technologies = $attackerTechnology;
		$this->fightingSystem->fight($attackers, $defenders);
	}
	
	public function onUseOwnForAtt() {
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if (isset($this->panelsForAttackers[$unit->getInternalName()]))
				$this->panelsForAttackers[$unit->getInternalName()]->setValue($unit->getAmount());
		}
		
		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies() as $technology) {
			if (isset($this->panelsForAttackersTechnology[$technology->getInternalName()]))
				$this->panelsForAttackersTechnology[$technology->getInternalName()]->setValue($technology->getLevel());
		}
	}
	
	public function onUseOwnForDeff() {
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if (isset($this->panelsForDefenders[$unit->getInternalName()]))
				$this->panelsForDefenders[$unit->getInternalName()]->setValue($unit->getAmount());
		}
		
		foreach (Rakuun_Intern_Production_Factory::getAllBuildings() as $building) {
			if (isset($this->panelsForDefendersBuildings[$building->getInternalName()]))
				$this->panelsForDefendersBuildings[$building->getInternalName()]->setValue($building->getLevel());
		}
		
		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies() as $technology) {
			if (isset($this->panelsForDefendersTechnology[$technology->getInternalName()]))
				$this->panelsForDefendersTechnology[$technology->getInternalName()]->setValue($technology->getLevel());
		}
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getFightingSystem() {
		return $this->fightingSystem;
	}

	public function getPanelsForDefenders() {
		return $this->panelsForDefenders;
	}
	
	public function getPanelsForAttackers() {
		return $this->panelsForAttackers;
	}
	
	public function getPanelsForDefendersTechnology() {
		return $this->panelsForDefendersTechnology;
	}
	
	public function getPanelsForAttackersTechnology() {
		return $this->panelsForAttackersTechnology;
	}
	
	public function getPanelsForDefendersBuildings() {
		return $this->panelsForDefendersBuildings;
	}
}

?>