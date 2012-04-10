<?php

class Rakuun_Intern_Production_Unit_Donany extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('donany');
		$this->setName('Donany');
		$this->setNamePlural('Donanies');
		$this->setBaseIronCosts(250);
		$this->setBaseBerylliumCosts(750);
		$this->setBaseEnergyCosts(500);
		$this->setBasePeopleCosts(10);
		$this->setBaseTimeCosts(15*60);
		$this->setBaseAttackValue(10);
		$this->setBaseDefenseValue(20);
		$this->setBaseSpeed(3*60);
		$this->setRessourceTransportCapacity(100);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT);
		$this->addNeededBuilding('airport', 1);
		$this->addNeededTechnology('antigravitation', 1);
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