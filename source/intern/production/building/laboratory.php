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

class Rakuun_Intern_Production_Building_Laboratory extends Rakuun_Intern_Production_Building {
	const RESEARCH_TIME_REDUCTION_PERCENT = 2;
	const EXP_FOR_COSTS = 1.1;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('laboratory');
		$this->setName('Forschungslabor');
		$this->setBaseIronCosts(480);
		$this->setBaseBerylliumCosts(240);
		$this->setBasePeopleCosts(24);
		$this->setBaseTimeCosts(16*60);
		$this->setMaximumLevel(50);
		$this->setShortDescription('Im Forschungslabor können neue Technologien, zum Beispiel zur Energiegewinnung oder für militärische Zwecke, erforscht werden.');
		$this->setLongDescription('Forschungslaboratorien erm&ouml;glichen mit ihren Ger&auml;tschaften eine zielgerichtete Forschung.
			<br/>
			Umso st&auml;rker das Forschungslabor ausgebaut wurde, umso bessere und gr&ouml;&szlig;ere Ger&auml;tschaften, die f&uuml;r schwierigere Forschungen oft unumg&auml;ngig sind, sind darin enthalten.
			<br/>
			Die Forscher sind die kl&uuml;gsten und kreativsten B&uuml;rger der Stadt und fr&ouml;nen mit Begeisterung ihrem Metier, oft arbeiten sie stundenlang unbezahlt im Labor, fasziniert von ihrer neusten Kreation.
			<br/>
			Nat&uuml;rlich ist man zwischen den Reagenzgl&auml;sern mit ihren &auml;tzenden und hochexlosiven Inhalten und den gigantischen Maschinen, die sich meistens auf eine winzige Fl&auml;che richten, nicht wirklich sicher, doch sind die Forscher sowieso von Natur aus ein eher vorsichtiger Schlag - wer auch nur einen kleinen Sicherheitsfehler macht, wird sofort fristlos entlassen.
			<br/>
			Bevor dann eine Technologie wirklich reif ist, vergehen oft zahllose Arbeitstunden des Testes und des Neubeginns.');
		$this->setPoints(2);
	}
	
	protected function defineEffects() {
		$futureLevel = $this->getLevel() + $this->getFutureLevels();
		$this->addEffect('Verkürzung der Forschungszeiten um insgesamt '.$this->getResearchTimerReductionPercent($futureLevel + 1).'% (vorher: '.$this->getResearchTimerReductionPercent($futureLevel).'%)');
	}
	
	private function getResearchTimerReductionPercent($level) {
		return self::RESEARCH_TIME_REDUCTION_PERCENT * $level;
	}
	
	//OVERRIDES
	public function getIronCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round(pow($this->getBaseIronCosts() * $level, self::EXP_FOR_COSTS));
	}
	
	public function getBerylliumCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round(pow($this->getBaseBerylliumCosts() * $level, self::EXP_FOR_COSTS));
	}
	
	public function getEnergyCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round(pow($this->getBaseEnergyCosts() * $level, self::EXP_FOR_COSTS));
	}
	
	public function getPeopleCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round(pow($this->getBasePeopleCosts() * $level, self::EXP_FOR_COSTS));
	}
}

?>