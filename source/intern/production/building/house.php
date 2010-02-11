<?php

class Rakuun_Intern_Production_Building_House extends Rakuun_Intern_Production_Building_Store {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('house');
		$this->setName('Wohnhaus');
		$this->setBaseIronCosts(1500);
		$this->setBaseBerylliumCosts(500);
		$this->setBasePeopleCosts(100);
		$this->setBaseTimeCosts(10*60);
		$this->setBaseCapacity(1000);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Jedes Wohnhaus erhöht die Anzahl der Bürger, die in der Stadt wohnen können.');
		$this->setLongDescription('Wohnhäuser sind größere Gebäude mit einer großen Anzahl Standard-Wohneinheiten.
			<br/>
			Da sie für die arbeitende Bevölkerung vorgesehen sind, sind es eher einfache aber dennoch recht passable Wohnungen.');
		$this->addEffect('Erhöht die Menge der Leute die in der Stadt wohnen können um '.($this->getCapacity($this->getLevel() + $this->getFutureLevels() + 1) - $this->getCapacity($this->getLevel() + $this->getFutureLevels())));
		$this->setPoints(5);
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function getCapacity($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return $level * $this->getBaseCapacity() * RAKUUN_STORE_CAPACITY_MULTIPLIER;
	}
}

?>