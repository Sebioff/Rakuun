<?php

class Rakuun_Intern_Production_Building_Energystore extends Rakuun_Intern_Production_Building_Store {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('energystore');
		$this->setName('Energiespeicher');
		$this->setBaseIronCosts(1800);
		$this->setBaseBerylliumCosts(1800);
		$this->setBasePeopleCosts(120);
		$this->setBaseTimeCosts(9*60);
		$this->setBaseCapacity(20000);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Durch den Ausbau des Energiespeichers wird die Menge der speicherbaren Energie erhöht.');
		$this->setLongDescription('Ein Energiespeicher besteht aus einer gigantischen Anzahl hochkapazitärer Kondensatoren in einer magnetisch isolierenden Hülle und wird speziell zum Speichern von Energie gebaut.');
		$this->setPoints(5);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöht die Kapazität der speicherbaren Energie um '.Text::formatNumber($this->getCapacity($this->getLevel() + $this->getFutureLevels() + 1) - $this->getCapacity($this->getLevel() + $this->getFutureLevels())));
	}
}

?>