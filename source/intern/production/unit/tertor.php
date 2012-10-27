<?php

class Rakuun_Intern_Production_Unit_Tertor extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('tertor');
		$this->setName('Tertor');
		$this->setNamePlural('Tertoren');
		$this->setBaseIronCosts(280);
		$this->setBaseBerylliumCosts(520);
		$this->setBaseEnergyCosts(400);
		$this->setBasePeopleCosts(8);
		$this->setBaseTimeCosts(16*60);
		$this->setBaseAttackValue(22);
		$this->setBaseDefenseValue(8);
		$this->setBaseSpeed(110);
		$this->setRessourceTransportCapacity(50);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT);
		$this->addNeededBuilding('airport', 1);
		$this->addNeededTechnology('plasmatechnology', 1);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_NotInNoobProtection());
		$this->setShortDescription('Tertor');
		$this->setLongDescription('Tertoren sind Antigrav-Bomber.
			<br/>
			Die großen Bombenschächte und die schweren Bomben kosten die Antigrav Einheit weit mehr Energie als die der Donanies, wodurch sie wesentlich langsamer vorrankommen und sogar von Tegos in Geschwindigkeit übertroffen werden.
			<br/>
			Dafür sind ihre Bomben ziemlich stark und schalten fast jede Verteidigung aus.
			<br/>
			Zusammen mit Buhoganis sind sie eine hervorragende Bunkerbrechungseinheit.
			<br/>
			Leider sind ihre Bomben relativ ungenau wenn es um das treffen zustürmender Einheiten geht, weshalb ihr Verteidigungspotential selbst das von einem Donany unterbietet.');
	}
}

?>