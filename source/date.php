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
 * Formats timestamps to human readable strings
 */
abstract class Rakuun_Date {
	public static function formatCountDown($timeInSeconds) {
		if ($timeInSeconds < 0)
			$timeInSeconds = 0;
		$seconds = $timeInSeconds % 60;
		$minutes = self::secondsToMinutes($timeInSeconds);
		$hours = self::secondsToHours($timeInSeconds);
		$days = self::secondsToDays($timeInSeconds);
		
		$result = '';
		if ($days > 0) {
			$multiple = '';
			if ($days > 1)
				$multiple='e';
			$result .= $days.' Tag'.$multiple.', ';
		}
		
		if ($hours >= 1)
			$unit = ' Stunden';
		else
			$unit = ' Minuten';
		$result .= self::addLeadingZero($hours).':'.self::addLeadingZero($minutes).':'.self::addLeadingZero($seconds).' '.$unit;
		
		
		return $result;
	}
	
	private static function secondsToMinutes($seconds) {
		return ($seconds / 60) % 60;
	}
	
	private static function secondsToHours($seconds) {
		return ($seconds / 60 / 60) % 24;
	}
	
	private static function secondsToDays($seconds) {
		return (int)($seconds / 60 / 60 / 24);
	}
	
	private static function addLeadingZero($number) {
		return (($number < 10) ? '0' : '').$number;
	}
}

?>