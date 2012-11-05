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

class Rakuun_Intern_Production_Technology_Hydropower extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('hydropower');
		$this->setName('Wassertechnik');
		$this->setBaseIronCosts(1600);
		$this->setBaseBerylliumCosts(2000);
		$this->setBaseTimeCosts(570*60);
		$this->addNeededBuilding('laboratory', 1);
		$this->setMaximumLevel(1);
		$this->setShortDescription('Wird zur Energiegewinnung benötigt.');
		$this->setLongDescription('Die Gewinnung von Energie aus der Kraft von Wasser ist ein relativ simpler Vorgang: man staut einen See an, durchzieht den Staudamm mit Röhren und fügt in diese Turbinen ein, die einen Dynamo antreiben.
			<br/>
			Dadurch, dass man lediglich ein wenig in Stabilität forschen muss, um sowohl die Röhre als auch die Turbine vor der Zerstörungskraft des reißenden Wasserstroms zu schützen, geht diese Forschung ziemlich schnell vorran, allerdings benötigt man zur Simulation ein Forschungslabor mit relativ fortgeschrittener Einrichtung.');
		$this->setPoints(10);
	}
}

?>