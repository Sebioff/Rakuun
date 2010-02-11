<?php

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