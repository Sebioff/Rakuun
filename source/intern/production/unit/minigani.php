<?php

class Rakuun_Intern_Production_Unit_Minigani extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('minigani');
		$this->setName('Minigani');
		$this->setNamePlural('Miniganis');
		$this->setBaseIronCosts(600);
		$this->setBaseBerylliumCosts(400);
		$this->setBaseEnergyCosts(400);
		$this->setBasePeopleCosts(20);
		$this->setBaseTimeCosts(15*60);
		$this->setBaseAttackValue(29);
		$this->setBaseDefenseValue(41);
		$this->setBaseSpeed(432);
		$this->setRessourceTransportCapacity(200);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE);
		$this->addNeededBuilding('tank_factory', 3);
		$this->addNeededTechnology('heavy_weaponry', 2);
		$this->addNeededTechnology('light_plating', 5);
		$this->addNeededTechnology('engine', 3);
		$this->setShortDescription('Minigani');
		$this->setLongDescription('Miniganis sind leichte Panzer.
			<br/>
			Ausgestattet mit 50 mm Kanonen durschlagen sie jede Panzerung und eignen ich daher prima als Bunkerbrecher.
			<br/>
			Ihr Motor ist dank des für Panzer relativ niedrigen Gewichtes von 10t in der Lage, sie ziemlich zu beschleunigen, sodass sie Fusstruppen selbst in Gelände übertreffen können.
			<br/>
			Die eher auf stabilen Metallen basierende Technologie sorgt außerdem für ein recht ausgeglichenes Bedürfniss an Rohstoffen.');
	}
}

?>