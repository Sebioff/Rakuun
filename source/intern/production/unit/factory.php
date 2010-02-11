<?php

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