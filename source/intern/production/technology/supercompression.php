<?php

class Rakuun_Intern_Production_Technology_Supercompression extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('supercompression');
		$this->setName('Superkompression');
		$this->setBaseIronCosts(35000);
		$this->setBaseBerylliumCosts(25000);
		$this->setBaseEnergyCosts(15000);
		$this->setBasePeopleCosts(15000);
		$this->setBaseTimeCosts(7*24*60*60+12*60*60);
		$this->addNeededBuilding('laboratory', 15);
		$this->setMaximumLevel(1);
		$this->setShortDescription('');
		$this->setLongDescription('');
		$this->setPoints(50);
	}
}

?>