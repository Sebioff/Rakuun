<?php

class Rakuun_Intern_Production_Building_CityWall extends Rakuun_Intern_Production_Building {
	const DEFENSE_BONUS_PERCENT = 4;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('city_wall');
		$this->setName('Stadtmauer');
		$this->setBaseIronCosts(7200);
		$this->setBaseEnergyCosts(4000);
		$this->setBasePeopleCosts(160);
		$this->setBaseTimeCosts(100*60);
		$this->addNeededBuilding('ironmine', 10);
		$this->addNeededBuilding('berylliummine', 10);
		$this->addNeededBuilding('clonomat', 1);
		$this->setMaximumLevel(3);
		$this->setShortDescription('Die Stadtmauer erhöht die Verteidigungskraft der in der Stadt vorhandenen Militäreinheiten um '.self::DEFENSE_BONUS_PERCENT.'% pro Stufe.');
		$this->setLongDescription('Stadtmauern erhöhen die Verteidigung der eigenen Einheiten während gegnerischen Angriffen.
			<br/>
			Die schon von weit her sichtbaren Bollwerke umgeben Städte völlig und lassen sie wie wahre Festungen aussehen.
			<br/>
			In ihnen patroulieren ständig Soldaten, umgeben von einer meterdicken Panzerung aus härtestem Material und modernster Warntechniken.
			<br/>
			Nur an einigen wenigen Punkten der Mauer befinden sich Tore, durch welche Zivilisten austreten können.
			<br/>
			Trotz der vielen Warnsignalgeber muss die Mauer durch eine beachtliche Zahl Personen kontrolliert werden; daher benötigen Stadtmauern Clon-O-Maten.');
		$this->setPoints(15);
	}
	
	protected function defineEffects() {
		$futureLevel = $this->getLevel() + $this->getFutureLevels();
		$this->addEffect('Verteidigungskraft-Bonus gegen alle Einheiten auf '.$this->getDefenseBonusPercent($futureLevel + 1).'% (vorher: '.$this->getDefenseBonusPercent($futureLevel).'%');
	}
	
	private function getDefenseBonusPercent($level) {
		return self::DEFENSE_BONUS_PERCENT * $level;
	}
}

?>