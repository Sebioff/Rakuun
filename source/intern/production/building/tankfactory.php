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

class Rakuun_Intern_Production_Building_TankFactory extends Rakuun_Intern_Production_Building {
	const PRODUCTION_TIME_REDUCTION_PERCENT = 2;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('tank_factory');
		$this->setName('Panzerfabrik');
		$this->setBaseIronCosts(1200);
		$this->setBaseBerylliumCosts(1200);
		$this->setBaseEnergyCosts(1200);
		$this->setBasePeopleCosts(16);
		$this->setBaseTimeCosts(8*60);
		$this->setMaximumLevel(50);
		$this->addNeededBuilding('military_base', 1);
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
		$futureLevel = $this->getLevel() + $this->getFutureLevels();
		$this->addEffect('Verkürzung der Produktionszeit von Fahrzeugen um insgesamt '.$this->getProductionTimeReductionPercent($futureLevel + 1).'% (vorher: '.$this->getProductionTimeReductionPercent($futureLevel).'%)');
	}
	
	private function getProductionTimeReductionPercent($level) {
		return self::PRODUCTION_TIME_REDUCTION_PERCENT * $level;
	}
}

?>