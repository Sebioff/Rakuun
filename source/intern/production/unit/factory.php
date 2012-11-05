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

abstract class Rakuun_Intern_Production_Unit_Factory {
	/**
	 * @param $unitSource DB_Record Either a Rakuun_DB_User, null (which results
	 * in returning units for the currently logged in user) or any other DB_Record
	 * that contains amounts of units
	 */
	public static function getAllOfType($unitType, DB_Record $unitSource = null) {
		$unitList = array();
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($unitSource) as $unit) {
			if ($unit->isOfUnitType($unitType)) {
				$unitList[] = $unit;
			}
		}
		
		return $unitList;
	}
}

?>