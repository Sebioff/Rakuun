<?php

class Rakuun_Intern_Production_Building_SensorBay extends Rakuun_Intern_Production_Building {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('sensor_bay');
		$this->setName('Sensorfeld');
		$this->setBaseIronCosts(1500);
		$this->setBaseBerylliumCosts(1500);
		$this->setBaseEnergyCosts(1000);
		$this->setBasePeopleCosts(20);
		$this->setBaseTimeCosts(20*60);
		$this->addNeededBuilding('airport', 2);
		$this->setShortDescription('Das Sensorfeld dient dem Entdecken von feindlichen Tarneinheiten, die sich auf dem Weg zu deiner Stadt befinden.<br />Je höher das Sensorfeld ausgebaut ist, desto früher können getarnte Einheiten aufgespürt werden.');
		$this->setLongDescription('Sensorfelder orten getarnte Angreifer.
			<br/>
			Während sowohl Lichtwellen als auch Schallimpulse von Tarnfeldern leicht umgelenkt werden können, ist es seit jeher ein Problem, die am Boden erzeugte Neutrino-Strahlung der Anti-G Einheiten ausreichend zu tarnen.
			<br/>
			Dieser Imperfektion bedienen sich Sensorfelder. In ihren hochempfindlichen Antennen nehmen sie selbst die schwächsten Neutrinoimpulse war und trennen die normalen Impulse, die ständig den ganzen Planeten durchdringen, von den kaum merklich stärkeren Neutrino-Nebenprodukten des Anti-G Feldes um sie dann während einiger komplizierter Berechnungen exakt auf ihre Ursprungsrichtung bestimmen zu können.
			<br/>
			Da für eine solche Technologie einige Erfahrungen hinsichtlich des Anti-G-Feldes nötig sind, müssen erfahrene Ingenieure und Wissenschaftler von Flughäfen während des Baus des Sensorfeldes auf dem Flughafengelände die nötigen Konfigurationen vornehmen.');
		$this->setPoints(8);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöht die Erkennungsreichweite getarnter Angriffe auf '.Rakuun_Date::formatCountDown($this->getRange($this->getLevel() + 1)));
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	public function getRange($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		if ($level > 0)
			return ($level - 1) * 10 * 60 + 15 * 60;
		else
			return 0;
	}
}

?>