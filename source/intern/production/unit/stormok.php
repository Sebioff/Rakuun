<?php

class Rakuun_Intern_Production_Unit_Stormok extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('stormok');
		$this->setName('Stormok');
		$this->setNamePlural('Stormoks');
		$this->setBaseIronCosts(250);
		$this->setBaseBerylliumCosts(750);
		$this->setBaseEnergyCosts(500);
		$this->setBasePeopleCosts(10);
		$this->setBaseTimeCosts(15*60);
		$this->setBaseAttackValue(10);
		$this->setBaseDefenseValue(20);
		$this->setBaseSpeed(160);
		$this->setRessourceTransportCapacity(100);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT);
		$this->addNeededBuilding('airport', 1);
		$this->addNeededTechnology('antigravitation', 1);
		$this->setShortDescription('Stormok');
		$this->setLongDescription('Stormoks verwenden die neusten Prinzipien der Tarnung und sind für normale Städte praktisch unsichtbar.
			<br/>
			Wie die Donanys verwenden sie Gattlins, auch wenn ihre einen Bonus im Treffen erfahren, da der Gegner Schwierigkeiten hat, den Schüssen eines nur durch Luftflirren wahrnehmbaren Gegners auszuweichen.
			<br/>
			Die Tarneinheit wiegt auch relativ wenig, was ihnen eine recht hohe Geschwindigkeit erlaubt.
			<br/>
			Ihre Unsichtbarkeit kann sich als großer Vorteil erweisen da der Gegner nicht in der Lage ist, sich auf den Angriff vorzubereiten.
			<br/>
			Daher dienen sie hauptsächlich dazu, schwächere, aber aktive Gegner auszuschalten.');
	}
}

?>