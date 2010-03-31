<?php

class Rakuun_Intern_Production_Unit_Lorica extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('lorica');
		$this->setName('Lorica');
		$this->setNamePlural('Loricas');
		$this->setBaseIronCosts(200);
		$this->setBaseBerylliumCosts(400);
		$this->setBaseEnergyCosts(100);
		$this->setBasePeopleCosts(5);
		$this->setBaseTimeCosts(15*60);
		$this->setBaseSpeed(78);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE);
		$this->addNeededBuilding('tank_factory', 1);
		$this->addNeededTechnology('light_plating', 3);
		$this->addNeededTechnology('engine', 5);
		$this->setShortDescription('Lorica');
		$this->setLongDescription('Loricas sind sogenannte BMTs, bemannte Mannschafts-Transporter.
			<br/>
			Sie dienen ausschließlich dem Personen- und Fahrzeugtransport und sind insofern auch unbewaffnet (abgesehen natürlich von der transportierten Infanterie), wenngleich sie eine einfache Panzerung besitzen.
			<br/>
			Die Fahrzeuge sind sehr schnell und wurden dafür entworfen, schnelle Plünderungen durchzuführen, wenngleich auch andere Anwendungsweisen denkbar sind.');
	}
}

?>