<?php

class Rakuun_Intern_Production_Technology_Supercompression extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('supercompression');
		$this->setName('Superkompression');
		$this->setBaseIronCosts(28000);
		$this->setBaseBerylliumCosts(20000);
		$this->setBaseEnergyCosts(12000);
		$this->setBasePeopleCosts(12000);
		$this->setBaseTimeCosts(6*24*60*60);
		$this->addNeededBuilding('laboratory', 15);
		$this->setMaximumLevel(1);
		$this->setShortDescription('');
		$this->setLongDescription('');
		$this->setPoints(50);
	}
}

?>