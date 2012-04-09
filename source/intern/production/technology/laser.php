<?php

class Rakuun_Intern_Production_Technology_Laser extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('laser');
		$this->setName('Lasertechnik');
		$this->setBaseIronCosts(30000);
		$this->setBaseBerylliumCosts(20000);
		$this->setBaseEnergyCosts(10000);
		$this->setBasePeopleCosts(10000);
		$this->setBaseTimeCosts(5*24*60*60);
		$this->addNeededBuilding('ironmine', 10);
		$this->addNeededBuilding('berylliummine', 8);
		$this->addNeededBuilding('laboratory', 5);
		$this->setMaximumLevel(1);
		$this->setShortDescription('Durch die Lasertechnik können Lasereinheiten produziert werden. Je höher die Laserforschung entwickelt ist, desto stärker sind die Lasereinheiten.');
		$this->setLongDescription('Laser ist eine Abkürzung für Light Amplification by Stimulatend Emmission of Radiation, einer Lichtverstärkung durch hervorgerufene Strahlungsemmission oder für Laien eine ungewöhnlich starke Lichtstrahlung, künstlich hervorgerufen durch einige Reaktionen die die Gasteilchen in den Laserkanonen zum strahlen bringen.
			<br/>
			Eine solche Forschung muss auf tausendstel Millimeter perfekt sein wenn nicht sogar mehr.
			<br/>
			Allein die Umsetzung der elektrischen Energie in Emmission ist eine schwere Aufgabe, aber die Bündelung der Lichtwellen zu einem dünnen Strahl ist nochmal ein ganz anderes Kaliber.
			<br/>
			Nur Top-Forschungslabore mit Präzisionsmaschinen sind überhaupt in der Lage, einen einfachen Prototypen herzustellen.');
		$this->setPoints(20);
	}
}

?>