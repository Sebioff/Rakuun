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
 * Factory class that maps strings to buildings, technologies or units.
 */
abstract class Rakuun_Intern_Production_Factory_Metas {
	private static $buildingList = array();
	
	/**
	 * @return Rakuun_Intern_Production_Building
	 */
	public static function getBuilding($internalName, DB_Record $buildingSource = null) {
		if (!self::$buildingList)
			self::generateBuildingList();
		
		if (!isset(self::$buildingList[$internalName]))
			return null;
			
		return new self::$buildingList[$internalName]($buildingSource);
	}
	
	public static function getAllBuildings(DB_Record $buildingSource = null) {
		if (!self::$buildingList)
			self::generateBuildingList();
		
		$buildingList = array();
		foreach (self::$buildingList as $internalName => $buildingClass) {
			$buildingList[] = new $buildingClass($buildingSource);
		}
		return $buildingList;
	}
	
	private static function addBuilding($internalName, $buildingClass) {
		self::$buildingList[$internalName] = $buildingClass;
	}
	
	private static function generateBuildingList() {
		self::addBuilding('space_port', 'Rakuun_Intern_Production_Building_Metas_SpacePort');
		self::addBuilding('dancertia', 'Rakuun_Intern_Production_Building_Metas_Dancertia');
	}
}

?>