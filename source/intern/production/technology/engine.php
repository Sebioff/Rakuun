<?php

class Rakuun_Intern_Production_Technology_Engine extends Rakuun_Intern_Production_Technology {
	const SPEED_BONUS_PERCENT = 5;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('engine');
		$this->setName('Antriebstechnik');
		$this->setBaseIronCosts(350);
		$this->setBaseBerylliumCosts(180);
		$this->setBaseEnergyCosts(120);
		$this->setBasePeopleCosts(50);
		$this->setBaseTimeCosts(240*60);
		$this->addNeededBuilding('laboratory', 2);
		$this->addNeededBuilding('tank_factory', 1);
		$this->setMaximumLevel(5);
		$this->setShortDescription('Die Antriebstechnik wird benötigt, um motorisierte Fahrzeuge produzieren zu können.');
		$this->setLongDescription('Antriebstechnik ist ein Oberbegriff für sämtliche Techniken, die primär darauf ausgelegt sind, ein Rad (oder eine Kette) zum rotieren zu bringen. Das umfasst sowohl Panzer- wie auch Buggymotoren.
			<br/>
			Die früher genutze Technik der Treibung eines Kolben durch eine kontrollierte Explosion wurde allerdings von einer vielversprechenderen, sparsameren Technik abgelöst: mehrere magnetisch geladene Objekte werden an einer Scheibe, die ihre Drehung auf die Räder überträgt, gesetzt und durch einige weitere, rund um die Scheibe gesetzte Elektromagneten, die durch spezielle Kanäle ihre Anziehung auf die einzelnen Magneten konzentrieren können, zur Bewegung gebracht.
			<br/>
			Diese Forschung befasst sich hauptsächlich mit der Perfektionierung des Kanalisierungsprozesses, ohne den die ganze Anlage lediglich ein energieverbrauchendes Objekt ohne Wirkung wäre.');
		$this->setPoints(9);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöht Einheitengeschwindigkeit um '.(self::SPEED_BONUS_PERCENT * ($this->getLevel() + $this->getFutureLevels() + 1)).'%');
	}
}

?>