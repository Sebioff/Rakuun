<?php

class Rakuun_Intern_Log_RessourcetransferOut extends Rakuun_Intern_Log {
	public static function log(Rakuun_DB_User $user, $action, Rakuun_DB_User $recipient, $iron, $beryllium = 0, $energy = 0, $people = 0) {
		self::multiCheck($recipient, $action);
		$logEntry = new DB_Record();
		$logEntry->user = $user;
		$logEntry->recipient = $recipient;
		$logEntry->time = time();
		$logEntry->ip = $_SERVER['REMOTE_ADDR'];
		$logEntry->hostname = gethostbyaddr($logEntry->ip);
		$logEntry->browser = $_SERVER['HTTP_USER_AGENT'];
		$logEntry->action = $action;
		$logEntry->iron = $iron;
		$logEntry->beryllium = $beryllium;
		$logEntry->energy = $energy;
		$logEntry->people = $people;
		Rakuun_DB_Containers::getLogUserRessourcetransferOutContainer()->save($logEntry);
	}
}

?>