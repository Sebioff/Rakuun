<?php

class Rakuun_Intern_Log_UnitsProduction {
	public static function log(Rakuun_DB_User $user, $producedUnitInternalName, $producedAmount) {
		$options = array();
		$options['conditions'][] = array('user = ?', $user);
		$options['conditions'][] = array('time = ?', mktime(0, 0, 0));
		if (!($logEntry = Rakuun_DB_Containers::getLogUnitsProductionContainer()->selectFirst($options)))
			$logEntry = new DB_Record();
		$logEntry->user = $user;
		$logEntry->time = mktime(0, 0, 0);
		$logEntry->{Text::underscoreToCamelCase($producedUnitInternalName)} += $producedAmount;
		Rakuun_DB_Containers::getLogUnitsProductionContainer()->save($logEntry);
	}
}

?>