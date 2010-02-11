<?php

class Rakuun_Intern_Production_Technology_Hydropower extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('hydropower');
		$this->setName('Wassertechnik');
		$this->setBaseIronCosts(2000);
		$this->setBaseBerylliumCosts(2500);
		$this->setBaseTimeCosts(720*60);
		$this->addNeededBuilding('laboratory', 3);
		$this->setMaximumLevel(1);
		$this->setShortDescription('Wird zur Energiegewinnung benötigt.');
		$this->setLongDescription('Die Gewinnung von Energie aus der Kraft von Wasser ist ein relativ simpler Vorgang: Man staut einen See an, durchzieht den Staudamm mit Röhren und fügt in diese Turbinen ein, die einen Dynamo antreiben.
			<br/>
			Dadurch, dass man lediglich ein wenig in Stabilität forschen muss, um sowohl die Röhre als auch die Turbine vor der Zerstörungskraft des reißenden Wasserstroms zu schützen, geht diese Forschung ziemlich schnell vorran, allerdings benötigt man zur Simulation ein Forschungslabor mit relativ fortgeschrittener Einrichtung.');
		$this->setPoints(10);
	}
}

?>