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

class Rakuun_Intern_Production_Building_Barracks extends Rakuun_Intern_Production_Building {
	const PRODUCTION_TIME_REDUCTION_PERCENT = 2;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('barracks');
		$this->setName('Kaserne');
		$this->setBaseIronCosts(1600);
		$this->setBaseBerylliumCosts(1200);
		$this->setBaseEnergyCosts(800);
		$this->setBasePeopleCosts(16);
		$this->setBaseTimeCosts(8*60);
		$this->setMaximumLevel(50);
		$this->addNeededBuilding('military_base', 1);
		$this->setShortDescription('In der Kaserne werden Soldaten ausgebildet.<br />Ein Ausbau bewirkt eine schnellere Ausbildung.');
		$this->setLongDescription('Kasernen sind für die Ausbildung der Infanterie vorgesehen, in höheren Stufen der Kaserne findet man außerdem kleinere Werften, in denen Spionagesonden konstruiert werden können.
			<br/>
			Schon von weit her hört man die Schreie der trainierenden Truppen. Unter strengen und harten Aufsehern wird praktisch den ganzen Tag für den Ernstfall geübt.
			<br/>
			Das Ausbildungsspektrum reicht von 30km Märschen über Schlachten in virtueller Umgebung mit künstlich hervorgeruftem Schmerz bis hin zu stundenlangen Liegestützen.
			<br/>
			Die hier ausgebildete Infanterie ist nicht nur in Kondition und Zielgenauigkeit gedrillt sondern beherrscht auch mehrere Nahkampfarten und stellt somit selbst unbewaffnet eine tödliche Kampfmaschine dar.
			<br/>
			Die Truppen lernen, auf Befehle zu gehorchen ohne dabei zu denken und auf alles zu ballern, was sich bewegt und nicht das eigene Emblem trägt.
			<br/>
			Die meisten Kasernen arbeiten zusätzlich mit Drogen, die sowohl die Brutalität als auch die Schmerzunempfindlichkeit steigern.
			<br/>
			Einige wenige Elitekasernen setzen dann statt dem die Ausbildung abschließenden virtuellen Kampf eine wirkliche Schlacht in Gange, in der die schwachen Soldaten durch die "natürliche Auslese" beseitigt werden.');
		$this->setPoints(10);
	}
	
	protected function defineEffects() {
		$futureLevel = $this->getLevel() + $this->getFutureLevels();
		$this->addEffect('Verkürzung der Produktionszeit von Infanterieeinheiten um insgesamt '.$this->getProductionTimeReductionPercent($futureLevel + 1).'% (vorher: '.$this->getProductionTimeReductionPercent($futureLevel).'%)');
	}
	
	private function getProductionTimeReductionPercent($level) {
		return self::PRODUCTION_TIME_REDUCTION_PERCENT * $level;
	}
}

?>