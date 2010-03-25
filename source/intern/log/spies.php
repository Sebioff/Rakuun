<?php

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
	}
}

?>