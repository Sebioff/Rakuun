<?php

class Rakuun_Intern_Production_Technology_LightWeaponry extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('light_weaponry');
		$this->setName('Leichte Waffentechnik');
		$this->setBaseIronCosts(20000);
		$this->setBaseBerylliumCosts(20000);
		$this->setBaseEnergyCosts(20000);
		$this->setBasePeopleCosts(10000);
		$this->setBaseTimeCosts(5*24*60*60);
		$this->addNeededBuilding('laboratory', 10);
		$this->setMaximumLevel(1);
		$this->setShortDescription('Grundwissen der Waffenanwendung, das für die Produktion schwächerer Militäreinheiten benötigt wird.');
		$this->setLongDescription('Leichte Waffentechnik konzentriert sich auf schnelle Waffen, die in kürzester Zeit möglichst zielgenau kleinere Projektile verschießen.
			<br/>
			Auch wenn solche Waffen kaum eine Chance gegen harte Panzerung haben, an der sie einfach abprallen, so sind sie sehr effektiv gegen größere Massen von Gegnern sowie auch gegen schnelle, eigentlich schwer zu treffende Objekte wie Flugzeuge oder die agilen Fusstruppen.');
		$this->setPoints(20);
	}
}

?>