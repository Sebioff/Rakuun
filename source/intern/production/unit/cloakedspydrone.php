<?php

class Rakuun_Intern_Production_Unit_CloakedSpydrone extends Rakuun_Intern_Production_Unit {
	const ROBUSTNESS_FACTOR = 1.75;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('cloaked_spydrone');
		$this->setName('Tarnsonde');
		$this->setNamePlural('Tarnsonden');
		$this->setBaseIronCosts(400);
		$this->setBaseBerylliumCosts(400);
		$this->setBaseEnergyCosts(400);
		$this->setBasePeopleCosts(2);
		$this->setBaseTimeCosts(5*60);
		$this->setBaseSpeed(20);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT);
		$this->addNeededBuilding('military_base', 10);
		$this->addNeededTechnology('cloaking', 1);
		$this->setAttribute(Rakuun_Intern_Production_Unit::ATTRIBUTE_CLOAKING, true);
		$this->setAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK, true);
		$this->setAttribute(Rakuun_Intern_Production_Unit::ATTRIBUTE_MOVE_OVER_WATER, true);
		$this->setShortDescription('Tarnsonde');
		$this->setLongDescription('Tarnsonden sind erweiterte Spionagesonden mit einem Tarngenerator.
			<br/>
			Ihre Herstellung ist um einiges teurer, dafür sind sie auch um den Faktor '.self::ROBUSTNESS_FACTOR.' robuster als normale Sonden.
			<br/>
			Ihr Vorteil ist klar der, dass viele Gegner nicht mehr in der Lage sind, vor dem Spionagebericht ihre Truppen außerhalb der Stadt zu verstecken um den Gegner im unklaren über ihre Armee zu lassen.
			<br/>
			<br/>
			Tarnsonden sind zudem in der Lage, auch mit der Verbesserten Tarnung ausgestattete Einheiten zu erkennen.
			<br/>
			Bei einem Spionageauftrag muss mehr als die Hälfte der Sonden aus Tarnsonden bestehen um Einheiten, die mit der Verbesserten Tarnung ausgerüstet sind, zuverlässig zu entdecken.');
	}
}

?>