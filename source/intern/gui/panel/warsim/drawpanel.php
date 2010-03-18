<?php

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
	}
	
	public function onCalcwarsim() {
		if ($this->hasErrors())
			return;
		
		$this->fightingSystem = new Rakuun_Intern_Fights_System();
		$defenders = new DB_Record();
		foreach ($this->panelsForDefenders as $unitName => $panel) {
			$defenders->{Text::underscoreToCamelCase($unitName)} = $panel->getValue();
		}
		$defenders->fightingSequence = Rakuun_Intern_Production_Unit::DEFAULT_DEFENSE_SEQUENCE;
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
		$attackers->fightingSequence = Rakuun_Intern_Production_Unit::DEFAULT_ATTACK_SEQUENCE;
		$attackerTechnology = new DB_Record();
		foreach ($this->panelsForAttackersTechnology as $technologyName => $panel) {
			$attackerTechnology->{Text::underscoreToCamelCase($technologyName)} = $panel->getValue();
		}
		$attackers->technologies = $attackerTechnology;
		$this->fightingSystem->fight($attackers, $defenders);
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