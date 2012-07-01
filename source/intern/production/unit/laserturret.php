<?php

class Rakuun_Intern_Production_Unit_LaserTurret extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('laser_turret');
		$this->setName('Laserturm');
		$this->setNamePlural('Lasertürme');
		$this->setBaseIronCosts(500);
		$this->setBaseBerylliumCosts(500);
		$this->setBaseEnergyCosts(500);
		$this->setBasePeopleCosts(10);
		$this->setBaseTimeCosts(20*60);
		$this->setBaseDefenseValue(22);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY);
		$this->addNeededBuilding('military_base', 1);
		$this->addNeededBuilding('city_wall', 1);
		$this->addNeededTechnology('cybernetics', 1);
		$this->addNeededTechnology('light_plating', 1);
		$this->addNeededTechnology('antigravitation', 1);
		$this->setShortDescription('Laserturm');
		$this->setLongDescription('Lasertürme sind größere Türme mit rotierbarem Kopf, die man mit intensiven Lasern ausgestattet hat.
			<br/>
			An den Frontlinien der Städte aufgestellt, sind sie für Angreifer eine große Bedrohung, was durch die hochenergetischen Laserblitze nicht gerade gemildert wird.
			<br/>
			Natürlich sind sie nicht in der Lage, sich zu bewegen, was sie für viele Städte uninterresant macht, trotz ihrer harten Durchschlagskraft.');
	}
}

?>