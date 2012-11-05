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

class Rakuun_Cronjob extends Cronjob_Manager {
	const FIGHT_DURATION = 240; // 4 minutes
	
	public function __construct($moduleName, $databaseTableName) {
		parent::__construct($moduleName, $databaseTableName);
		
		// NOTE: cronjobs are executed every 2 minutes, so intervals must be multiples of 2
		$this->addScript(new Rakuun_Cronjob_Script_DailyCleanup('daily_cleanup', 0, 0)); // daily at 00:00
		$this->addScript(new Rakuun_Cronjob_Script_Cleanup('cleanup', 6 * 60 * 60)); // every 6 hours
		$this->addScript(new Rakuun_Cronjob_Script_Tick('tick', 2 * 60)); // every 2 minutes
		$this->addScript(new Rakuun_Cronjob_Script_Fight('fight', Rakuun_Cronjob::FIGHT_DURATION)); // every 4 minutes
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function onScriptException(Core_Exception $ce, Cronjob_Script $script) {
		try {
			Rakuun_Module::onError($ce->getTrace(), 'Cronjob: '.$script->getIdentifier().'. '.$ce->getMessage(), 'Fehler bei Cronjob');
		}
		catch (Core_Exception $ce) {
			echo 'An error occured in a cronjob script and sending an error mail failed!';
		}
	}
	
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return (
			$_SERVER['SERVER_ADDR'] == $_SERVER['REMOTE_ADDR']
			|| ($user && Rakuun_TeamSecurity::get()->isInGroup($user, Rakuun_TeamSecurity::GROUP_ADMINS))
		);
	}
}

?>