<?php

/**
 * @deprecated
 */
class Rakuun_Intern_Production_Unit_Telaturri extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('telaturri');
		$this->setName('Telaturri');
		$this->setNamePlural('Telaturris');
		$this->setBaseIronCosts(800);
		$this->setBaseBerylliumCosts(300);
		$this->setBasePeopleCosts(10);
		$this->setBaseTimeCosts(15*60);
		$this->setBaseDefenseValue(40);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY);
		$this->addNeededBuilding('military_base', 4);
		$this->addNeededTechnology('heavy_weaponry', 3);
		$this->addNeededTechnology('light_plating', 5);
		$this->setShortDescription('Telaturri');
		$this->setLongDescription('Der Telaturri ist eine sogennante <b>FL</b>ug<b>A</b>bwehr<b>K</b>anone.
			<br/>
			Er besteht aus einer drehbaren Scheibe mit einem längeren Lauf, dessen Winkel fast beliebig variiert werden kann.
			<br/>
			Durch moderne Servomotoren und eine Laser-Zielerfassung kann er in wenigen Sekunden eine Vollschwenkung durchführen. Die Besatzung der Kanone nimmt daher, abgesehen vom Schützen, eher eine wartende und reparierende Rolle ein.
			<br/>
			Der größte Vorteil des Turmes ist sein niedriger Verbrauch an Energie, da er immer noch auf dem alten Projektil-Prinzip basiert.
			<br/>
			Telaturris haben eine hohe Feuergeschwindigkeit mit eher schwächeren Projektilen und sind daher besonders gut gegen die schnellen Gleiter geeignet und weniger gegen langsame, aber gut gepanzerte Fahrzeuge.');
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function getDefenseValueAgainst($unitType, $amount = null) {
		// telaturris only really work against aircraft
		if (self::containsUnitType($unitType, self::TYPE_AIRCRAFT))
			$defenseValue = $this->getDefenseValue($amount);
		else
			if ($amount !== null)
				$defenseValue = $amount;
			else
				$defenseValue = $this->getAmount();
		
		$boniPercent = $this->getBoniPercentAgainst($unitType);
		
		if ($boniPercent != 0)
			$defenseValue += $defenseValue / 100 * $boniPercent;
		
		return $defenseValue;
	}
}

?>