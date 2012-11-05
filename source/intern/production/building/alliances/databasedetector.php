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

abstract class Rakuun_Intern_Production_Building_Alliances_DatabaseDetector extends Rakuun_Intern_Production_AllianceBuilding {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setBaseIronCosts(10000);
		$this->setBaseBerylliumCosts(10000);
		$this->setBaseTimeCosts(24*60*60);
		$this->setMaximumLevel(5);
		$this->setShortDescription('Der Datenbank-Detektor wird benötigt, um die Datenbankteile finden und transportieren zu können.<br />Durch einen Ausbau wird der Bonus, den das Datenbankteil pro gehaltenem Tag gibt, erhöht.<br />');
	}
}

?>