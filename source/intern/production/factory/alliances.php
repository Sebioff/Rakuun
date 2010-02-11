<?php

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
	
	private static function addBuilding($internalName, $buildingClass) {
		self::$buildingList[$internalName] = $buildingClass;
	}
	
	private static function generateBuildingList() {
		self::addBuilding('database_detector', 'Rakuun_Intern_Production_Building_Alliances_DatabaseDetector');
	}
}

?>