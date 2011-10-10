<?php

class Rakuun_Intern_Production_Building_Ironstore extends Rakuun_Intern_Production_Building_Store {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('ironstore');
		$this->setName('Eisenlager');
		$this->setBaseIronCosts(1500);
		$this->setBaseBerylliumCosts(1200);
		$this->setBasePeopleCosts(90);
		$this->setBaseTimeCosts(18*60);
		$this->setBaseCapacity(10000);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Durch den Ausbau des Eisenlagers wird die Menge des lagerbaren Eisens erhöht.');
		$this->setLongDescription('Ein Eisenlager ist ein recht stabiles Gebäude, das speziell zum Lagern von Eisen gebaut wird.');
		$this->setPoints(5);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöht die Menge des lagerbaren Eisens um '.Text::formatNumber($this->getCapacity($this->getLevel() + $this->getFutureLevels() + 1) - $this->getCapacity($this->getLevel() + $this->getFutureLevels())));
	}
}

?>