<?php

class Rakuun_Intern_Production_Unit_Donany extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('donany');
		$this->setName('Donany');
		$this->setNamePlural('Donanies');
		$this->setBaseIronCosts(750);
		$this->setBaseBerylliumCosts(500);
		$this->setBaseEnergyCosts(550);
		$this->setBasePeopleCosts(40);
		$this->setBaseTimeCosts(19*60);
		$this->setBaseAttackValue(50);
		$this->setBaseDefenseValue(14);
		$this->setBaseSpeed(236);
		$this->setRessourceTransportCapacity(100);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT);
		$this->addNeededBuilding('airport', 1);
		$this->addNeededTechnology('heavy_weaponry', 3);
		$this->addNeededTechnology('heavy_plating', 3);
		$this->addNeededTechnology('jet', 3);
		$this->addNeededTechnology('antigravitation', 1);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_NotInNoobProtection());
		$this->setShortDescription('Donany');
		$this->setLongDescription('Donanys sind die allererste je gebaute Antigravitations-Kampfeinheit.
			<br/>
			Sie sind hauptsächlich auf Agilität ausgelegt und können innerhalb weniger Stunden ferne Orte erreichen und mit ihren Gattlin-Kanonen beschießen.
			<br/>
			Ihr geringer Laderaum macht sie als Plündereinheit weniger effektiv, daher werden sie hauptsächlich als Blitz-Kampfeinheit und als Kontereinheit benutzt.
			<br/>
			Da Flugeinheiten ihren Antigrav ersteinmal aktivieren müssen, haben sie ein recht niedriges Verteidigungspotential.');
	}
}

?>