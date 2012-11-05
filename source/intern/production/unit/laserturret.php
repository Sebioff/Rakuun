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

class Rakuun_Intern_Production_Unit_LaserTurret extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('laser_turret');
		$this->setName('Laserturm');
		$this->setNamePlural('Lasertürme');
		$this->setBaseIronCosts(400);
		$this->setBaseBerylliumCosts(400);
		$this->setBaseEnergyCosts(400);
		$this->setBasePeopleCosts(8);
		$this->setBaseTimeCosts(16*60);
		$this->setBaseDefenseValue(22);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY);
		$this->addNeededBuilding('military_base', 1);
		$this->addNeededBuilding('city_wall', 1);
		$this->addNeededTechnology('cybernetics', 1);
		$this->addNeededTechnology('light_plating', 1);
		$this->addNeededTechnology('antigravitation', 1);
		$this->setShortDescription('Laserturm');
		$this->setLongDescription('Lasertürme sind größere Türme mit rotierbarem Kopf, die man mit intensiven Lasern ausgestattet hat.
			<br/>
			An den Frontlinien der Städte aufgestellt, sind sie für Angreifer eine große Bedrohung, was durch die hochenergetischen Laserblitze nicht gerade gemildert wird.
			<br/>
			Natürlich sind sie nicht in der Lage, sich zu bewegen, was sie für viele Städte uninterresant macht, trotz ihrer harten Durchschlagskraft.');
	}
}

?>