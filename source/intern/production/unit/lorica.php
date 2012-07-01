<?php

class Rakuun_Intern_Production_Unit_Lorica extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('lorica');
		$this->setName('Lorica');
		$this->setNamePlural('Loricas');
		$this->setBaseIronCosts(525);
		$this->setBaseBerylliumCosts(525);
		$this->setBaseEnergyCosts(550);
		$this->setBasePeopleCosts(15);
		$this->setBaseTimeCosts(17*60+30);
		$this->setBaseAttackValue(15);
		$this->setBaseDefenseValue(15);
		$this->setBaseSpeed(160);
		$this->setRessourceTransportCapacity(1000);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER);
		$this->addNeededBuilding('barracks', 15);
		$this->addNeededTechnology('cybernetics', 3);
		$this->addNeededTechnology('supercompression', 1);
		$this->setShortDescription('Lorica');
		$this->setLongDescription('Loricas sind sogenannte BMTs, bemannte Mannschafts-Transporter.
			<br/>
			Sie dienen ausschließlich dem Personen- und Fahrzeugtransport und sind insofern auch unbewaffnet (abgesehen natürlich von der transportierten Infanterie), wenngleich sie eine einfache Panzerung besitzen.
			<br/>
			Die Fahrzeuge sind sehr schnell und wurden dafür entworfen, schnelle Plünderungen durchzuführen, wenngleich auch andere Anwendungsweisen denkbar sind.');
	}
}

?>