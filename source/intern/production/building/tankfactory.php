<?php

class Rakuun_Intern_Production_Building_TankFactory extends Rakuun_Intern_Production_Building {
	const PRODUCTION_TIME_REDUCTION_PERCENT = 2;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('tank_factory');
		$this->setName('Panzerfabrik');
		$this->setBaseIronCosts(2000);
		$this->setBaseBerylliumCosts(2000);
		$this->setBasePeopleCosts(80);
		$this->setBaseTimeCosts(18*60);
		$this->setMaximumLevel(50);
		$this->addNeededBuilding('ironmine', 10);
		$this->addNeededBuilding('berylliummine', 8);
		$this->addNeededBuilding('military_base', 2);
		$this->setShortDescription('Die Panzerfabrik ermöglicht die Produktion von Panzern.<br />Ein Ausbau bewirkt eine schnellere Produktion.');
		$this->setLongDescription('In Panzerfabriken werden je nach Stufe unterschiedlich mächtige Panzer produziert.
			Diese Fabriken sind mit modernster Technik ausgestattet.
			<br/>
			Ständig werden Chassis auf Belastbarkeit geprüft und Panzerplatten geschweißt, denen man höchste Stabilität und Leichtigkeit abverlangt.
			<br/>
			Gleichzeitig werden Modellen im weiteren Verlauf der Produktion mit mächtigen Waffen bestückt, die das Markenzeichen aller aus den Panzerfabriken kommenden Einheiten sind: die leichten Raketenwerfer der Tegos, die gigantischen Artilleriegeschütze der Buhoganis...
			<br/>
			Um Ingenieur in einer solchen Anlage zu werden, benötigt man beachtliche Referenzen. Peinlichste Genauigkeit im Nachprüfen der Chassis ist Pflicht. Kleinste Fehler in der Vermessung würden die Karriere eines Ingenieurs drastisch beenden.
			<br/>
			Den Wert ihres Berufes erkennen die Mechaniker dann, wenn die wuchtigen Maschinen mit lautem Rasseln aus den Garagen rollen um alles niederzuwälzen, was sich ihnen in den Weg stellt.');
		$this->setPoints(10);
	}
	
	protected function defineEffects() {
		$this->addEffect('Verkürzung der Produktionszeit von Fahrzeugen um insgesamt '.(self::PRODUCTION_TIME_REDUCTION_PERCENT * ($this->getLevel() + $this->getFutureLevels() + 1)).'%');
	}
}

?>