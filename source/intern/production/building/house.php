<?php

class Rakuun_Intern_Production_Building_House extends Rakuun_Intern_Production_Building_Store {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('house');
		$this->setName('Wohnhaus');
		$this->setBaseIronCosts(1800);
		$this->setBaseBerylliumCosts(600);
		$this->setBasePeopleCosts(120);
		$this->setBaseTimeCosts(8*60);
		$this->setBaseCapacity(4800);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Jedes Wohnhaus erhöht die Anzahl der Bürger, die in der Stadt wohnen können.');
		$this->setLongDescription('Wohnhäuser sind größere Gebäude mit einer großen Anzahl Standard-Wohneinheiten.
			<br/>
			Da sie für die arbeitende Bevölkerung vorgesehen sind, sind es eher einfache aber dennoch recht passable Wohnungen.');
		$this->setPoints(5);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöht die Menge der Leute die in der Stadt wohnen können um '.Text::formatNumber($this->getCapacity($this->getLevel() + $this->getFutureLevels() + 1) - $this->getCapacity($this->getLevel() + $this->getFutureLevels())));
	}
}

?>