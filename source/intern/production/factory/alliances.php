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
abstract class Rakuun_Intern_Production_Factory_Alliances {
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
	
	/**
	 * @return Rakuun_Intern_Production_Building
	 */
	public static function getDetectorForDatabase($databaseIdentifier, DB_Record $buildingSource = null) {
		$internalName = '';
		switch ($databaseIdentifier) {
			case Rakuun_User_Specials::SPECIAL_DATABASE_BLUE:
				$internalName = 'database_detector_blue';
			break;
			case Rakuun_User_Specials::SPECIAL_DATABASE_BROWN:
				$internalName = 'database_detector_brown';
			break;
			case Rakuun_User_Specials::SPECIAL_DATABASE_GREEN:
				$internalName = 'database_detector_green';
			break;
			case Rakuun_User_Specials::SPECIAL_DATABASE_RED:
				$internalName = 'database_detector_red';
			break;
			case Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW:
				$internalName = 'database_detector_yellow';
			break;
		}
		
		return self::getBuilding($internalName, $buildingSource);
	}
	
	private static function addBuilding($internalName, $buildingClass) {
		self::$buildingList[$internalName] = $buildingClass;
	}
	
	private static function generateBuildingList() {
		self::addBuilding('database_detector_blue', 'Rakuun_Intern_Production_Building_Alliances_DatabaseDetectorBlue');
		self::addBuilding('database_detector_brown', 'Rakuun_Intern_Production_Building_Alliances_DatabaseDetectorBrown');
		self::addBuilding('database_detector_green', 'Rakuun_Intern_Production_Building_Alliances_DatabaseDetectorGreen');
		self::addBuilding('database_detector_red', 'Rakuun_Intern_Production_Building_Alliances_DatabaseDetectorRed');
		self::addBuilding('database_detector_yellow', 'Rakuun_Intern_Production_Building_Alliances_DatabaseDetectorYellow');
	}
}

?>