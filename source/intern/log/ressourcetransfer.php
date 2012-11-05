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

class Rakuun_Intern_Log_Ressourcetransfer extends Rakuun_Intern_Log {
	public static function log(Rakuun_DB_User $user, $action, Rakuun_DB_User $sender, $iron, $beryllium = 0, $energy = 0, $people = 0) {
		self::multiCheck($sender, $action);
		$logEntry = new DB_Record();
		$logEntry->user = $user;
		$logEntry->sender = $sender;
		$logEntry->time = time();
		$logEntry->ip = $_SERVER['REMOTE_ADDR'];
		$logEntry->hostname = gethostbyaddr($logEntry->ip);
		$logEntry->browser = getenv('HTTP_USER_AGENT');
		$logEntry->action = $action;
		$logEntry->iron = $iron;
		$logEntry->beryllium = $beryllium;
		$logEntry->energy = $energy;
		$logEntry->people = $people;
		Rakuun_DB_Containers::getLogUserRessourcetransferContainer()->save($logEntry);
	}
}

?>