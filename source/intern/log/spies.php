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

class Rakuun_Intern_Log_Spies {
	public static function log(Rakuun_DB_User $user, Rakuun_DB_User $spiedUser, DB_Record $ressources, array $buildings, array $units) {
		$logEntry = new DB_Record();
		$logEntry->user = $user;
		$logEntry->spiedUser = $spiedUser;
		$logEntry->time = time();
		$logEntry->iron = $ressources->iron;
		$logEntry->beryllium = $ressources->beryllium;
		$logEntry->energy = $ressources->energy;
		$logEntry->people = $ressources->people;
		foreach ($buildings as $internalName => $level)
			$logEntry->{Text::underscoreToCamelCase($internalName)} = $level;
		foreach ($units as $internalName => $amount)
			$logEntry->{Text::underscoreToCamelCase($internalName)} = $amount;
		Rakuun_DB_Containers::getLogSpiesContainer()->save($logEntry);
		
		return $logEntry;
	}
}

?>