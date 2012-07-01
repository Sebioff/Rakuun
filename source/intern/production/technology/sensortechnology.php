<?php

class Rakuun_Intern_Production_Technology_SensorTechnology extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('sensor_technology');
		$this->setName('Sensorik');
		$this->setBaseIronCosts(20000);
		$this->setBaseBerylliumCosts(30000);
		$this->setBaseEnergyCosts(10000);
		$this->setBasePeopleCosts(10000);
		$this->setBaseTimeCosts(5*24*60*60);
		$this->addNeededBuilding('laboratory', 10);
		$this->setMaximumLevel(1);
		$this->setShortDescription('');
		$this->setLongDescription('');
		$this->setPoints(20);
	}
}

?>