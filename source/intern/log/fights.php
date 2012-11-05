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

class Rakuun_Intern_Log_Fights {
	const TYPE_WON = 0;
	const TYPE_LOST = 1;
	const TYPE_SPY = 2;
	
	const ROLE_ATTACKER = 0;
	const ROLE_DEFENDER = 1;
	
	public static function log(Rakuun_DB_User $winner, Rakuun_DB_User $loser, Rakuun_DB_User $attacker, array $winnerLostUnits, array $loserLostUnits, $fightID) {
		$winnerLogEntry = new DB_Record();
		$winnerLogEntry->user = $winner;
		$winnerLogEntry->opponent = $loser;
		$winnerLogEntry->time = time();
		$winnerLogEntry->type = self::TYPE_WON;
		$winnerLogEntry->role = ($winner->getPK() == $attacker->getPK()) ? self::ROLE_ATTACKER : self::ROLE_DEFENDER;
		$winnerLogEntry->fightID = $fightID;
		foreach ($winnerLostUnits as $internalUnitName => $lostAmount)
			$winnerLogEntry->{Text::underscoreToCamelCase($internalUnitName)} = $lostAmount;
		Rakuun_DB_Containers::getLogFightsContainer()->save($winnerLogEntry);
		$loserLogEntry = new DB_Record();
		$loserLogEntry->user = $loser;
		$loserLogEntry->opponent = $winner;
		$loserLogEntry->time = time();
		$loserLogEntry->type = self::TYPE_LOST;
		$loserLogEntry->role = ($loser->getPK() == $attacker->getPK()) ? self::ROLE_ATTACKER : self::ROLE_DEFENDER;
		$loserLogEntry->fightID = $fightID;
		foreach ($loserLostUnits as $internalUnitName => $lostAmount)
			$loserLogEntry->{Text::underscoreToCamelCase($internalUnitName)} = $lostAmount;
		Rakuun_DB_Containers::getLogFightsContainer()->save($loserLogEntry);
	}
	
	public static function logSpy(Rakuun_DB_User $attacker, Rakuun_DB_User $defender, array $attackerLostUnits, $fightID) {
		$attackerLogEntry = new DB_Record();
		$attackerLogEntry->user = $attacker;
		$attackerLogEntry->opponent = $defender;
		$attackerLogEntry->time = time();
		$attackerLogEntry->type = self::TYPE_SPY;
		$attackerLogEntry->role = self::ROLE_ATTACKER;
		$attackerLogEntry->fightID = $fightID;
		foreach ($attackerLostUnits as $internalUnitName => $lostAmount)
			$attackerLogEntry->{Text::underscoreToCamelCase($internalUnitName)} = $lostAmount;
		Rakuun_DB_Containers::getLogFightsContainer()->save($attackerLogEntry);
	}
}

?>