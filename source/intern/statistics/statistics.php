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
 * calc all Ingame Statistic Informations
 * @author dr.dent
 */
abstract class Rakuun_Intern_Statistics {
	
	/**
	 * @return average Points of all Users
	 * TODO can/should be cached
	 */
	public static function averagePoints($withoutInactive = false, $withoutNoobs = false) {
		$options = array();
		$options['properties'] = 'SUM(points) AS sum_points';
		if ($withoutInactive)
			$options['conditions'][] = array('is_yimtay = ?', 0);
		if ($withoutNoobs)
			$options['conditions'][] = array('points > ?', RAKUUN_NOOB_START_LIMIT_OF_POINTS);
		$sumOfPoints = Rakuun_DB_Containers::getUserContainer()->selectFirst($options)->sumPoints;
		$average = $sumOfPoints / Rakuun_Intern_Statistics::noOfPlayers($withoutInactive);
		return $average;
	}
	
	public static function getNoobPointLimit() {
		return max(RAKUUN_NOOB_START_LIMIT_OF_POINTS, Rakuun_Intern_Statistics::averagePoints(true, true) * 0.6);
	}
	
	/**
	 * @return No of All Players
	 */
	public static function noOfPlayers($withoutInactive = false, $withoutNoobs = false) {
		$options = array();
		if ($withoutInactive)
			$options['conditions'][] = array('is_yimtay = ?', 0);
		if ($withoutNoobs)
			$options['conditions'][] = array('points > ?', RAKUUN_NOOB_START_LIMIT_OF_POINTS);
		return Rakuun_DB_Containers::getUserContainer()->count($options);
	}
	
	/**
	 * @return average army strength of all users
	 */
	public static function averageArmyStrength($withoutInactive = false) {
		$options = array();
		$units = Rakuun_Intern_Production_Factory::getAllUnits();
		$armyStrength = 0;
		
		$properties = array();
		foreach ($units as $unit)
			$properties[] = 'SUM('.$unit->getInternalName().') AS sum_'.$unit->getInternalName();
		
		$options['properties'] = implode(', ', $properties);
		if ($withoutInactive) {
			$options['join'] = array('users');
			$options['conditions'][] = array('users.id = user');
			$options['conditions'][] = array('users.is_yimtay = ?', 0);
		}
		$unitSums = Rakuun_DB_Containers::getUnitsContainer()->selectFirst($options);
		
		foreach ($units as $unit)
			$armyStrength += $unitSums->{Text::underscoreToCamelCase('sum_'.$unit->getInternalName())} * $unit->getBaseArmyStrength();
		
		return $armyStrength / Rakuun_Intern_Statistics::noOfPlayers($withoutInactive);
	}
	
	public static function getNoobArmyStrengthLimit() {
		return max(RAKUUN_NOOB_START_LIMIT_OF_ARMY_STRENGTH, Rakuun_Intern_Statistics::averageArmyStrength(true) * 0.6);
	}
	
	/**
	 * @return Number of all atts which are done since beginning
	 */
	public static function noOfAtts() {
		$options['properties'] = 'MAX(id) AS max';
		return Rakuun_DB_Containers::getArmiesContainer()->selectFirst($options)->max;
	}
	
	public static function noOfRunningAtts() {
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
	
	/*
	 * @param user
	 * @return rankposition of a user
	 */
	public static function getRank(Rakuun_DB_User $user) {
		$options['conditions'][] = array('points > ?', $user->points);
		return Rakuun_DB_Containers::getUserContainer()->count($options) + 1;
	}
	
	public static function noOfInactiveUsers() {
		$options['conditions'][] = array('is_yimtay = ?', true);
		return Rakuun_DB_Containers::getUserContainer()->count($options);
	}
	
	public static function noOfLoggedInUsers() {
		$options['conditions'][] = array('is_online > ?', time() - Rakuun_Intern_Module::TIMEOUT_ISONLINE);
		return Rakuun_DB_Containers::getUserContainer()->count($options);
	}
}

?>