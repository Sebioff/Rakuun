<?php

class Rakuun_Intern_Production_Technology_Plasmatechnology extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('plasmatechnology');
		$this->setName('Plasmatechnik');
		$this->setBaseIronCosts(2000);
		$this->setBaseBerylliumCosts(3000);
		$this->setBaseEnergyCosts(1000);
		$this->setBasePeopleCosts(1000);
		$this->setBaseTimeCosts(60*60);
		$this->addNeededBuilding('laboratory', 1);
		$this->addNeededBuilding('airport', 1);
		$this->setMaximumLevel(1);
		$this->setShortDescription('');
		$this->setLongDescription('');
		$this->setPoints(20);
	}
}

?>