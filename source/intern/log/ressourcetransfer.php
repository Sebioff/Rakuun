<?php

class Rakuun_Intern_Log_Ressourcetransfer extends Rakuun_Intern_Log {
	public static function log(Rakuun_DB_User $user, $action, Rakuun_DB_User $sender, $iron, $beryllium = 0, $energy = 0, $people = 0) {
		self::multiCheck($sender, $action);
		$logEntry = new DB_Record();
		$logEntry->user = $user;
		$logEntry->sender = $sender;
		$logEntry->time = time();
		$logEntry->ip = $_SERVER['REMOTE_ADDR'];
		$logEntry->hostname = gethostbyaddr($logEntry->ip);
		$logEntry->browser = $_SERVER['HTTP_USER_AGENT'];
		$logEntry->action = $action;
		$logEntry->iron = $iron;
		$logEntry->beryllium = $beryllium;
		$logEntry->energy = $energy;
		$logEntry->people = $people;
		Rakuun_DB_Containers::getLogUserRessourcetransferContainer()->save($logEntry);
	}
}

?>