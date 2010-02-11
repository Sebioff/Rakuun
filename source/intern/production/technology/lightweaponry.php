<?php

class Rakuun_Intern_Production_Technology_LightWeaponry extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('light_weaponry');
		$this->setName('Leichte Waffentechnik');
		$this->setBaseIronCosts(200);
		$this->setBaseBerylliumCosts(150);
		$this->setBasePeopleCosts(70);
		$this->setBaseTimeCosts(50*60);
		$this->setInfluence(Rakuun_Intern_Production_Technology::INFLUENCE_ATTACK);
		$this->addNeededBuilding('laboratory', 3);
		$this->addNeededBuilding('barracks', 1);
		$this->setMaximumLevel(5);
		$this->setShortDescription('Grundwissen der Waffenanwendung, das für die Produktion schwächerer Militäreinheiten benötigt wird.');
		$this->setLongDescription('Leichte Waffentechnik konzentriert sich auf schnelle Waffen, die in kürzester Zeit möglichst zielgenau kleinere Projektile verschießen.
			<br/>
			Auch wenn solche Waffen kaum eine Chance gegen harte Panzerung haben, an der sie einfach abprallen, so sind sie sehr effektiv gegen größere Massen von Gegnern sowie auch gegen schnelle, eigentlich schwer zu treffende Objekte wie Flugzeuge oder die agilen Fusstruppen.');
		$this->setPoints(5);
	}
}

?>