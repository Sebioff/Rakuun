<?php

class Rakuun_Intern_Log_Userdata extends Rakuun_Intern_Log {
	public static function log(Rakuun_DB_User $user, $action, $data = '') {
		$logEntry = new DB_Record();
		$logEntry->user = $user;
		$logEntry->time = time();
		$logEntry->ip = $_SERVER['REMOTE_ADDR'];
		$logEntry->hostname = gethostbyaddr($logEntry->ip);
		$logEntry->browser = $_SERVER['HTTP_USER_AGENT'];
		$logEntry->action = $action;
		$logEntry->data = $data;
		Rakuun_DB_Containers::getLogUserDataContainer()->save($logEntry);
	}
}

?>