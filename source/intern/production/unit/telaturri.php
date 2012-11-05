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

/**
 * @deprecated
 */
class Rakuun_Intern_Production_Unit_Telaturri extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('telaturri');
		$this->setName('Telaturri');
		$this->setNamePlural('Telaturris');
		$this->setBaseIronCosts(640);
		$this->setBaseBerylliumCosts(240);
		$this->setBasePeopleCosts(8);
		$this->setBaseTimeCosts(12*60);
		$this->setBaseDefenseValue(40);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY);
		$this->addNeededBuilding('military_base', 4);
		$this->addNeededTechnology('heavy_weaponry', 3);
		$this->addNeededTechnology('light_plating', 5);
		$this->setShortDescription('Telaturri');
		$this->setLongDescription('Der Telaturri ist eine sogennante <b>FL</b>ug<b>A</b>bwehr<b>K</b>anone.
			<br/>
			Er besteht aus einer drehbaren Scheibe mit einem längeren Lauf, dessen Winkel fast beliebig variiert werden kann.
			<br/>
			Durch moderne Servomotoren und eine Laser-Zielerfassung kann er in wenigen Sekunden eine Vollschwenkung durchführen. Die Besatzung der Kanone nimmt daher, abgesehen vom Schützen, eher eine wartende und reparierende Rolle ein.
			<br/>
			Der größte Vorteil des Turmes ist sein niedriger Verbrauch an Energie, da er immer noch auf dem alten Projektil-Prinzip basiert.
			<br/>
			Telaturris haben eine hohe Feuergeschwindigkeit mit eher schwächeren Projektilen und sind daher besonders gut gegen die schnellen Gleiter geeignet und weniger gegen langsame, aber gut gepanzerte Fahrzeuge.');
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function getDefenseValueAgainst($unitType, $amount = null) {
		// telaturris only really work against aircraft
		if (self::containsUnitType($unitType, self::TYPE_AIRCRAFT))
			$defenseValue = $this->getDefenseValue($amount);
		else
			if ($amount !== null)
				$defenseValue = $amount;
			else
				$defenseValue = $this->getAmount();
		
		$boniPercent = $this->getBoniPercentAgainst($unitType);
		
		if ($boniPercent != 0)
			$defenseValue += $defenseValue / 100 * $boniPercent;
		
		return $defenseValue;
	}
}

?>