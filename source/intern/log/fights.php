<?php

class Rakuun_Intern_Log_Fights {
	const TYPE_WON = 0;
	const TYPE_LOST = 1;
	
	public static function log(Rakuun_DB_User $winner, Rakuun_DB_User $loser, array $winnerLostUnits, array $loserLostUnits, $fightID) {
		$winnerLogEntry = new DB_Record();
		$winnerLogEntry->user = $winner;
		$winnerLogEntry->time = time();
		$winnerLogEntry->type = self::TYPE_WON;
		$winnerLogEntry->fightID = $fightID;
		foreach ($winnerLostUnits as $internalUnitName => $lostAmount)
			$winnerLogEntry->{Text::underscoreToCamelCase($internalUnitName)} = $lostAmount;
		Rakuun_DB_Containers::getLogFightsContainer()->save($winnerLogEntry);
		$loserLogEntry = new DB_Record();
		$loserLogEntry->user = $loser;
		$loserLogEntry->time = time();
		$loserLogEntry->type = self::TYPE_LOST;
		$loserLogEntry->fightID = $fightID;
		foreach ($loserLostUnits as $internalUnitName => $lostAmount)
			$loserLogEntry->{Text::underscoreToCamelCase($internalUnitName)} = $lostAmount;
		Rakuun_DB_Containers::getLogFightsContainer()->save($loserLogEntry);
	}
}

?>