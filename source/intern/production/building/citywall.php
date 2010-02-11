<?php

class Rakuun_Intern_Production_Building_CityWall extends Rakuun_Intern_Production_Building {
	const DEFENSE_BONUS_PERCENT = 4;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('city_wall');
		$this->setName('Stadtmauer');
		$this->setBaseIronCosts(9000);
		$this->setBaseEnergyCosts(5000);
		$this->setBasePeopleCosts(200);
		$this->setBaseTimeCosts(240*60);
		$this->addNeededBuilding('ironmine', 10);
		$this->addNeededBuilding('berylliummine', 10);
		$this->addNeededBuilding('clonomat', 1);
		$this->setMaximumLevel(3);
		$this->setShortDescription('Die Stadtmauer erhöht die Verteidigungskraft der in der Stadt vorhandenen Militäreinheiten um 4% pro Stufe.');
		$this->setLongDescription('Stadtmauern erhöhen die Verteidigung der eigenen Einheiten während gegnerischen Angriffen.
			<br/>
			Die schon von weit her sichtbaren Bollwerke umgeben Städte völlig und lassen sie wie wahre Festungen aussehen.
			<br/>
			In ihnen patroulieren ständig Soldaten, umgeben von einer meterdicken Panzerung aus härtestem Material und modernster Warntechniken.
			<br/>
			Nur an einigen wenigen Punkten der Mauer befinden sich Tore durch welche Zivilisten austreten können.
			<br/>
			Trotz der vielen Warnsignalgeber muss die Mauer durch eine beachtliche Zahl Personen kontrolliert werden, daher benötigen Stadtmauern Clon-O-Maten.');
		$this->setPoints(15);
	}
	
	protected function defineEffects() {
		$this->addEffect('Verteidigungskraft-Bonus gegen Nicht-Flugeinheiten auf '.(self::DEFENSE_BONUS_PERCENT * ($this->getLevel() + $this->getFutureLevels() + 1)).'%');
	}
}

?>