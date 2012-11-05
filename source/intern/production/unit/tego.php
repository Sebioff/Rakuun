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
 * TODO remove if it is absolutely clear that this won't be used anymore
 * @deprecated
 */
class Rakuun_Intern_Production_Unit_Tego extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('tego');
		$this->setName('Tego');
		$this->setNamePlural('Tegos');
		$this->setBaseIronCosts(200);
		$this->setBaseBerylliumCosts(400);
		$this->setBaseEnergyCosts(100);
		$this->setBasePeopleCosts(5);
		$this->setBaseTimeCosts(12*60);
		$this->setBaseAttackValue(14);
		$this->setBaseDefenseValue(21);
		$this->setBaseSpeed(138);
		$this->setRessourceTransportCapacity(150);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE);
		$this->addNeededBuilding('tank_factory', 1);
		$this->addNeededTechnology('light_weaponry', 3);
		$this->addNeededTechnology('light_plating', 1);
		$this->addNeededTechnology('engine', 4);
		$this->setShortDescription('Tego');
		$this->setLongDescription('Ein Tego ist eine Art Mischung aus vergrößertem Buggy und Jeep.
			<br/>
			Diese Fahrzeuge sind dank ihrer hohen Geschwindigkeit, die kein anderes Landfahrzeug übertrifft, besonders für Blitzkriege gut geeignet.
			<br/>
			Ausgestattet mit leichten KSR-Werfern sind sie auch in der Lage, härter gepanzerte Dinge zu vernichten.
			<br/>
			Ihr übergroßer Motor benötigt allerdings große Mengen Beryllium zur Herstellung da er über spezielle Kühl- und Steuerungssysteme verfügt, die seine Geschwindigkeit erst möglich machen.');
	}
}

?>