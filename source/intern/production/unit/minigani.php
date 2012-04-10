<?php

class Rakuun_Intern_Production_Unit_Minigani extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('minigani');
		$this->setName('Minigani');
		$this->setNamePlural('Miniganis');
		$this->setBaseIronCosts(800);
		$this->setBaseBerylliumCosts(200);
		$this->setBaseEnergyCosts(500);
		$this->setBasePeopleCosts(10);
		$this->setBaseTimeCosts(15*60);
		$this->setBaseAttackValue(10);
		$this->setBaseDefenseValue(20);
		$this->setBaseSpeed(3*60);
		$this->setRessourceTransportCapacity(100);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE);
		$this->addNeededBuilding('tank_factory', 1);
		$this->addNeededTechnology('light_plating', 1);
		$this->setShortDescription('Minigani');
		$this->setLongDescription('Miniganis sind leichte Panzer.
			<br/>
			Ausgestattet mit 50 mm Kanonen durschlagen sie jede Panzerung und eignen sich daher prima als Bunkerbrecher.
			<br/>
			Ihr Motor ist dank des für Panzer relativ niedrigen Gewichtes von 10t in der Lage, sie stark zu beschleunigen, sodass sie Fusstruppen selbst in Gelände übertreffen können.
			<br/>
			Die eher auf stabilen Metallen basierende Technologie sorgt außerdem für ein recht ausgeglichenes Bedürfniss an Rohstoffen.');
	}
}

?>