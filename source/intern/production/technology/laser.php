<?php

class Rakuun_Intern_Production_Technology_Laser extends Rakuun_Intern_Production_Technology {
	const FORCE_BONUS_PERCENT = 7;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('laser');
		$this->setName('Lasertechnik');
		$this->setBaseIronCosts(250);
		$this->setBaseBerylliumCosts(150);
		$this->setBaseEnergyCosts(200);
		$this->setBaseTimeCosts(210*60);
		$this->setInfluence(Rakuun_Intern_Production_Technology::INFLUENCE_ATTACK);
		$this->addNeededBuilding('ironmine', 10);
		$this->addNeededBuilding('berylliummine', 8);
		$this->addNeededBuilding('laboratory', 5);
		$this->setMaximumLevel(6);
		$this->setShortDescription('Durch die Lasertechnik kannst du Lasereinheiten bauen. Je höher die Laserforschung entwickelt ist, desto besser sind die Lasereinheiten.');
		$this->setLongDescription('Laser ist eine Abkürzung für Light Amplification by Stimulatend Emmission of Radiation, einer Lichtverstärkung durch hervorgerufene Strahlungsemmission oder für Laien eine ungewöhnlich starke Lichtstrahlung, künstlich hervorgerufen durch einige Reaktionen die die Gasteilchen in den Laserkanonen zum strahlen bringen.
			<br/>
			Eine solche Forschung muss auf tausendstel Millimeter perfekt sein wenn nicht sogar mehr.
			<br/>
			Allein die Umsetzung der elektrischen Energie in Emmission ist eine schwere Sache, aber die Bündelung der Lichtwellen zu einem dünnen Strahl ist nochmal ein ganz anderes Kaliber.
			<br/>
			Nur Top-Forschungslabore mit Präzisionsmaschinen sind überhaupt in der Lage, einen einfachen Prototypen herzustellen.');
		$this->setPoints(8);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöht Kampfkraft um '.(self::FORCE_BONUS_PERCENT * ($this->getLevel() + $this->getFutureLevels() + 1)).'%');
	}
}

?>