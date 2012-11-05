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
class Rakuun_Intern_Production_Technology_HeavyWeaponry extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('heavy_weaponry');
		$this->setName('Schwere Waffentechnik');
		$this->setBaseIronCosts(900);
		$this->setBaseBerylliumCosts(1100);
		$this->setBaseEnergyCosts(700);
		$this->setBasePeopleCosts(90);
		$this->setBaseTimeCosts(120*60);
		$this->setInfluence(Rakuun_Intern_Production_Technology::INFLUENCE_ATTACK);
		$this->addNeededBuilding('laboratory', 5);
		$this->addNeededBuilding('barracks', 3);
		$this->addNeededBuilding('tank_factory', 4);
		$this->addNeededTechnology('light_weaponry', 5);
		$this->setMaximumLevel(6);
		$this->setShortDescription('Fortgeschrittene Waffenkenntnisse, die für die Produktion von stärkeren Militäreinheiten benötigt werden.');
		$this->setLongDescription('Die schwere Waffentechnik bezieht sich auf Waffen, die eine hohe Durchschlagskraft haben, dafür eine relativ niedrige Schussfolge und ein langsames Handhaben.
			<br/>
			Einfache Fusstruppen sind meist zu agil um von solchen schweren Projektilen und Raketen getroffen zu werden, ebenso sind Gleiter einfach zu schwer zu treffen, besonders, da viele dieser Projektile (von Raketen abgesehen) nicht einmal in der Lage sind, auf die Höhe der Gleiter zu kommen.
			<br/>
			Langsame Panzer, an denen leichte Schüsse einfach abprallen, sind allerdings das ideale Ziel für diese Waffenklasse.');
		$this->setPoints(8);
	}
}

?>