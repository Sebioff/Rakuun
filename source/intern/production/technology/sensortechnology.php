<?php

class Rakuun_Intern_Production_Technology_SensorTechnology extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('sensor_technology');
		$this->setName('Sensorik');
		$this->setBaseIronCosts(5000);
		$this->setBaseBerylliumCosts(5000);
		$this->setBaseEnergyCosts(5000);
		$this->setBasePeopleCosts(1000);
		$this->setBaseTimeCosts(24*60*60);
		$this->addNeededBuilding('laboratory', 1);
		$this->setMaximumLevel(4);
		$this->setShortDescription('');
		$this->setLongDescription('');
		$this->setPoints(20);
	}
}

?>