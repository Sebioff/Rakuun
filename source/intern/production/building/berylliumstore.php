<?php

class Rakuun_Intern_Production_Building_Berylliumstore extends Rakuun_Intern_Production_Building_Store {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('berylliumstore');
		$this->setName('Berylliumlager');
		$this->setBaseIronCosts(1000);
		$this->setBaseBerylliumCosts(1200);
		$this->setBasePeopleCosts(80);
		$this->setBaseTimeCosts(8*60);
		$this->setBaseCapacity(24000);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Durch den Ausbau des Berylliumlagers wird die Menge des lagerbaren Berylliums erhöht.');
		$this->setLongDescription('Ein Berylliumlager ist ein Komplex mit vielen luftgepolsterten Kammern, der speziell zum Lagern von Beryllium geeignet ist.');
		$this->setPoints(5);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöht die Menge des lagerbaren Berylliums um '.Text::formatNumber($this->getCapacity($this->getLevel() + $this->getFutureLevels() + 1) - $this->getCapacity($this->getLevel() + $this->getFutureLevels())));
	}
}

?>