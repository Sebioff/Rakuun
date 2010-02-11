<?php

class Rakuun_Intern_Log_UserActivity extends Rakuun_Intern_Log {
	public static function log(Rakuun_DB_User $user, $action, $additionalBrowserInfo = '') {
		self::multiCheck($user, $action);
		$logEntry = new DB_Record();
		$logEntry->user = $user;
		$logEntry->time = time();
		$logEntry->ip = $_SERVER['REMOTE_ADDR'];
		$logEntry->hostname = gethostbyaddr($logEntry->ip);
		$logEntry->browser = $_SERVER['HTTP_USER_AGENT'].' '.$additionalBrowserInfo;
		if (isset($_COOKIE['data']))
			$logEntry->cookie = $_COOKIE['data'];
		$logEntry->action = $action;
		Rakuun_DB_Containers::getLogUserActivityContainer()->save($logEntry);
	}
}

?>