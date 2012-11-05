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

class Rakuun_Intern_Production_Technology_Momo extends Rakuun_Intern_Production_Technology {
	const BUILDING_TIME_REDUCTION_PERCENT = 5;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('momo');
		$this->setName('MoMo');
		$this->setBaseIronCosts(800);
		$this->setBaseBerylliumCosts(480);
		$this->setBaseEnergyCosts(320);
		$this->setBasePeopleCosts(40);
		$this->setBaseTimeCosts(24*60);
		$this->addNeededBuilding('laboratory', 3);
		$this->setMaximumLevel(19);
		$this->setShortDescription('MoMo (Momentum Modularrecycling) nutzt eine komplizierte Technik, die eine Beschleunigung der Bauvorgänge ermöglicht.');
		$this->setLongDescription('Das Momentum Modularrecycling (MoMo) ist eine hochentwickelte Technologie, die den Bauprozess von Gebäuden deutlich beschleunigen kann.
			<br/>
			Der funktionale Kern dieser technischen Meisterleistung ist der Tempoglobulus-Generator, eine komplexe Vorrichtung zur Erzeugung einer großen Zeitblase, die, je nach Größe des Generators, ganze Gebäude umhüllen kann.
			<br/>
			Innerhalb dieser Blase läuft die Zeit deutlich schneller ab als außerhalb. Leider gilt dies nicht nur für Objekte oder Geschwindigkeiten, mit denen Arbeiten erledigt werden können, sondern auch für den Alterungsprozess der Personen, die sich im Wirkungsbereich der Zeitblase aufhalten. Deshalb werden nur einfache Arbeitsmannschaften hineingelassen, die regelmäßig ausgetauscht werden. Um raschem Schwund an akademischen Fachkräften vorzubeugen, werden in den Zeitblasen keine Forschungsarbeiten betrieben. Das Problem, dass Forschungen viel Zeit kosten und nicht effizient beschleunigbar sind, konnte noch nicht gelöst werden.
			<br/>
			Ein vollständiges Zurücksetzen der Zeit auf ein bereits vergangenes Datum ist bislang ebenfalls noch nicht gelungen.');
		$this->setPoints(5);
	}
	
	protected function defineEffects() {
		$futureLevel = $this->getLevel() + $this->getFutureLevels();
		$this->addEffect('Verkürzung der Bauzeit von Gebäuden um insgesamt '.$this->getBuildingTimeReductionPercent($futureLevel + 1).'% (vorher: '.$this->getBuildingTimeReductionPercent($futureLevel).'%)');
	}
	
	private function getBuildingTimeReductionPercent($level) {
		return self::BUILDING_TIME_REDUCTION_PERCENT * $level;
	}
}

?>