<?php

class Rakuun_Intern_Production_Unit_LaserTurret extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('laser_turret');
		$this->setName('Laserturm');
		$this->setNamePlural('Lasertürme');
		$this->setBaseIronCosts(500);
		$this->setBaseBerylliumCosts(500);
		$this->setBaseEnergyCosts(400);
		$this->setBasePeopleCosts(20);
		$this->setBaseTimeCosts(10*60);
		$this->setBaseDefenseValue(37);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY);
		$this->addNeededBuilding('military_base', 5);
		$this->addNeededBuilding('city_wall', 1);
		$this->addNeededBuilding('hydropower_plant', 3);
		$this->addNeededTechnology('heavy_weaponry', 1);
		$this->addNeededTechnology('heavy_plating', 3);
		$this->addNeededTechnology('laser', 2);
		$this->setShortDescription('Laserturm');
		$this->setLongDescription('Lasertürme sind größere Türme mit rotierbarem Kopf die man mit ziemlich intensiven Lasern ausgestattet hat.
			<br/>
			An den Frontlinien der Städte aufgestellt, sind sie für Angreifer eine große Bedrohung, was durch die hochenergetischen Laserblitze nicht gerade gemildert wird.
			<br/>
			Natürlich sind sie nicht in der Lage, sich zu bewegen, was sie für viele Städte uninterresant macht, trotz ihrer harten Durchschlagskraft.');
	}
}

?>