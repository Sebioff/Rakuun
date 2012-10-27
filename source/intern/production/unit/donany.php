<?php

class Rakuun_Intern_Production_Unit_Donany extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('donany');
		$this->setName('Donany');
		$this->setNamePlural('Donanies');
		$this->setBaseIronCosts(420);
		$this->setBaseBerylliumCosts(420);
		$this->setBaseEnergyCosts(440);
		$this->setBasePeopleCosts(12);
		$this->setBaseTimeCosts(14*60);
		$this->setBaseAttackValue(15);
		$this->setBaseDefenseValue(15);
		$this->setBaseSpeed(13);
		$this->setRessourceTransportCapacity(50);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT);
		$this->addNeededBuilding('airport', 15);
		$this->addNeededTechnology('antigravitation', 3);
		$this->addNeededTechnology('jet', 1);
		$this->setAttribute(Rakuun_Intern_Production_Unit::ATTRIBUTE_MOVE_OVER_WATER, true);
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