<?php

class Rakuun_Intern_Production_Technology_Cybernetics extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('cybernetics');
		$this->setName('Kybernetik');
		$this->setBaseIronCosts(3000);
		$this->setBaseBerylliumCosts(2000);
		$this->setBaseEnergyCosts(1000);
		$this->setBasePeopleCosts(1000);
		$this->setBaseTimeCosts(60*60);
		$this->addNeededBuilding('barracks', 1);
		$this->setMaximumLevel(3);
		$this->setShortDescription('');
		$this->setLongDescription('');
		$this->setPoints(10);
	}
}

?>