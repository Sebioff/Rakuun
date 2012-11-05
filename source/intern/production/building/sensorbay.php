<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

class Rakuun_Intern_Production_Building_SensorBay extends Rakuun_Intern_Production_Building {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('sensor_bay');
		$this->setName('Sensorfeld');
		$this->setBaseIronCosts(1200);
		$this->setBaseBerylliumCosts(1200);
		$this->setBaseEnergyCosts(800);
		$this->setBasePeopleCosts(16);
		$this->setBaseTimeCosts(8*60);
		$this->addNeededTechnology('sensor_technology', 2);
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
		$futureLevel = $this->getLevel() + $this->getFutureLevels();
		$this->addEffect('Erhöht die Erkennungsreichweite getarnter Angriffe auf '.Rakuun_Date::formatCountDown($this->getRange($futureLevel + 1)).' (vorher: '.Rakuun_Date::formatCountDown($this->getRange($futureLevel)).')');
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