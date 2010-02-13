<?php

/**
 * calc all Ingame Statistic Informations
 * @author dr.dent
 */
abstract class Rakuun_Intern_Statistics {
	
	/**
	 * @return average Points of all Users
	 * TODO can/should be cached
	 */
	public static function averagePoints() {
		$options = array();
		$options['properties'] = 'SUM(points) AS sum_points';
		$sumOfPoints = Rakuun_DB_Containers::getUserContainer()->selectFirst($options)->sumPoints;
		$average = $sumOfPoints / Rakuun_Intern_Statistics::noOfPlayers();
		return $average;
	}
	
	/**
	 * @return No of All Players
	 */
	public static function noOfPlayers() {
		return Rakuun_DB_Containers::getUserContainer()->count();
	}
	
	/**
	 * @return average army strength of all users
	 */
	public static function averageArmyStrength() {
		$options = array();
		$units = Rakuun_Intern_Production_Factory::getAllUnits();
		$armyStrength = 0;
		
		$properties = array();
		foreach ($units as $unit)
			$properties[] = 'SUM('.$unit->getInternalName().') AS sum_'.$unit->getInternalName();
		
		$options['properties'] = implode(', ', $properties);
		$unitSums = Rakuun_DB_Containers::getUnitsContainer()->selectFirst($options);
		
		foreach ($units as $unit)
			$armyStrength += $unitSums->{Text::underscoreToCamelCase('sum_'.$unit->getInternalName())} * $unit->getArmyStrength();
		
		return $armyStrength / Rakuun_Intern_Statistics::noOfPlayers();
	}
	
	/**
	 * @return Number of all atts which are done since beginning
	 */
	static public function noOfAtts() {
		$options['properties'] = 'MAX(id) AS max';
		return Rakuun_DB_Containers::getArmiesContainer()->selectFirst($options)->max;
	}
	
	static public function noOfRunningAtts() {
		return Rakuun_DB_Containers::getArmiesContainer()->count();
	}
	
	/**
	 * @return Number of all alliances
	 */
	public static function noOfAllies() {
		return Rakuun_DB_Containers::getAlliancesContainer()->count();
	}
	
	/**
	 * @return Number of all Metas
	 */
	public static function noOfMetas() {
		return Rakuun_DB_Containers::getMetasContainer()->count();
	}
	
	public static function lastRegisteredUser() {
		//TODO
	}
	
	public static function lastLoggedInUser() {
		//TODO
	}
	
	public static function noOfLockedUsers() {
		//TODO
	}
	
	public static function noOfCautionPoints() {
		$options = array();
		$options['properties'] = 'SUM(points) AS caution_points';
		return Rakuun_DB_Containers::getCautionContainer()->selectFirst($options)->cautionPoints;
	}
	
	public static function noOfCautionedUsers() {
		$options = array();
		$options['properties'] = 'COUNT(DISTINCT user) AS count_result';
		return Rakuun_DB_Containers::getCautionContainer()->selectFirst($options)->countResult;
	}
	
}

?>