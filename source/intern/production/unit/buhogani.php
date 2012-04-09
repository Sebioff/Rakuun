<?php

class Rakuun_Intern_Production_Unit_Buhogani extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('buhogani');
		$this->setName('Buhogani');
		$this->setNamePlural('Buhoganis');
		$this->setBaseIronCosts(100);
		$this->setBaseBerylliumCosts(900);
		$this->setBaseEnergyCosts(500);
		$this->setBasePeopleCosts(10);
		$this->setBaseTimeCosts(20*60);
		$this->setBaseAttackValue(20);
		$this->setBaseDefenseValue(10);
		$this->setBaseSpeed(4*60);
		$this->setRessourceTransportCapacity(50);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_NotInNoobProtection());
		$this->addNeededBuilding('tank_factory', 5);
		$this->addNeededTechnology('heavy_weaponry', 5);
		$this->addNeededTechnology('heavy_plating', 1);
		$this->addNeededTechnology('engine', 4);
		$this->setShortDescription('Buhogani');
		$this->setLongDescription('Der Buhogani ist um einiges härter gepanzert als sein kleiner Bruder, der Minigani, und besitzt mit 76 mm Kanonen eine bei weitem durchschlagendere Kraft.
			<br/>
			Die schweren Ketten und das ultraharte Chassis behindern die Agilität des Koloss allerdings stark, sodass er eher kriecht als fährt und sogar von Fusstruppen überholt wird.
			<br/>
			Seine Verwendung findet er daher eher in fortgesetzten Kriegen um harte Verteidigungslinien zu durchbrechen oder bereits zerstörte Städte völlig in Schlacke zu verwandeln.');
	}
}

?>