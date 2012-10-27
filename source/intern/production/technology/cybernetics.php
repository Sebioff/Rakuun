<?php

class Rakuun_Intern_Production_Technology_Cybernetics extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('cybernetics');
		$this->setName('Kybernetik');
		$this->setBaseIronCosts(240);
		$this->setBaseBerylliumCosts(1600);
		$this->setBaseEnergyCosts(800);
		$this->setBasePeopleCosts(800);
		$this->setBaseTimeCosts(48*60);
		$this->addNeededBuilding('laboratory', 1);
		$this->addNeededBuilding('barracks', 1);
		$this->setMaximumLevel(3);
		$this->setShortDescription('');
		$this->setLongDescription('');
		$this->setPoints(10);
	}
}

?>
