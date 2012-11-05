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

class Rakuun_Cronjob_Script_Cleanup extends Cronjob_Script {
	const CLEANUP_INACTIVE_YIMTAY = 1814400; // 3 weeks
	const CLEANUP_INACTIVE_DELETE = 6048000; // 10 weeks
	const CLEANUP_NOTACTIVATED_REMEMBER = 86400; // 1 day
	const CLEANUP_NOTACTIVATED_DELETE = 259200; // 3 days
	
	public function execute() {
		// REMOVE INACTIVE PLAYERS ---------------------------------------------
		$options = array();
		$options['conditions'][] = array('last_login < ?', time() - self::CLEANUP_INACTIVE_DELETE);
		$options['conditions'][] = array('registration_time < ?', time() - self::CLEANUP_INACTIVE_DELETE);
		DB_Connection::get()->beginTransaction();
		foreach (Rakuun_DB_Containers::getUserContainer()->select($options) as $deletedUser) {
			Rakuun_Intern_Log_UserActivity::log($deletedUser, Rakuun_Intern_Log::ACTION_ACTIVITY_DELETE_INACTIVE);
			// we can't use delete by $options here because the delete handler of the container wouldn't work
			Rakuun_User_Manager::delete($deletedUser, 'Inaktiv');
		}
		DB_Connection::get()->commit();
		
		// MAKE INACTIVE PLAYERS TO YIMTAY -------------------------------------
		$options = array();
		$options['conditions'][] = array('last_login < ?', time() - self::CLEANUP_INACTIVE_YIMTAY);
		$options['conditions'][] = array('registration_time < ?', time() - self::CLEANUP_INACTIVE_YIMTAY);
		$options['conditions'][] = array('is_yimtay = ?', false);
		DB_Connection::get()->beginTransaction();
		foreach (Rakuun_DB_Containers::getUserContainer()->select($options) as $yimtayUser) {
			if (Rakuun_GameSecurity::get()->isInGroup($yimtayUser, Rakuun_GameSecurity::GROUP_DEMO))
				continue;
			
			$alliance = $yimtayUser->alliance;
			$yimtayUser->cityName = 'Yimtay-City';
			$yimtayUser->alliance = null;
			$yimtayUser->isYimtay = 1;
			$yimtayUser->isInNoob = 0;
			Rakuun_User_Manager::update($yimtayUser);
			Rakuun_User_Manager::lock($yimtayUser);
			if ($sittedUser = Rakuun_DB_Containers::getUserContainer()->selectBySitterFirst($yimtayUser)) {
				$sittedUser->sitter = null;
				$sittedUser->save();
			}
			if ($alliance) {
				if (Rakuun_DB_Containers::getUserContainer()->countByAlliance($alliance) == 0) {
					Rakuun_DB_Containers::getAlliancesContainer()->delete($alliance);
				}
			}
			$workers = Rakuun_DB_Containers::getBuildingsWorkersContainer()->selectByUserFirst($yimtayUser);
			$ironmine = Rakuun_Intern_Production_Factory::getBuilding('ironmine', $yimtayUser);
			$berylliummine = Rakuun_Intern_Production_Factory::getBuilding('berylliummine', $yimtayUser);
			$hydropowerPlant = Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant', $yimtayUser);
			$clonomat = Rakuun_Intern_Production_Factory::getBuilding('clonomat', $yimtayUser);
			$workers->ironmine = $ironmine->getRequiredWorkers();
			$workers->berylliummine = $berylliummine->getRequiredWorkers();
			$workers->hydropowerPlant = $hydropowerPlant->getRequiredWorkers();
			$workers->clonomat = $clonomat->getRequiredWorkers();
			$workers->save();
		}
		DB_Connection::get()->commit();
		
		// SEND REMEMBER MAIL TO NOT ACTIVATED ACCOUNTS ------------------------
		$options = array();
		$options['conditions'][] = array('time < ?', time() - self::CLEANUP_NOTACTIVATED_REMEMBER);
		$options['conditions'][] = array('has_been_remembered = ?', false);
		foreach (Rakuun_DB_Containers::getUserActivationContainer()->select($options) as $activation) {
			$mail = new Net_Mail();
			$mail->setSubject('Rakuun: Account noch nicht aktiviert');
			$mail->addRecipients($activation->user->nameUncolored.' <'.$activation->user->mail.'>');
			$params = array('code' => $activation->code);
			$activationURL = App::get()->getActivationModule()->getURL($params);
			$mail->setMessage(
				'Rakuun
				---------------------------------------------------
				
				Hallo '.$activation->user->nameUncolored.',
				inzwischen sind 24 Stunden vergangen, seitdem du dich bei Rakuun angemeldet hast; allerdings hast du deinen Account noch nicht aktiviert. Vielleicht hast du die erste Aktivierungs-EMail ja gar nicht erhalten? Deswegen erhältst du sie hiermit zur Sicherheit noch einmal.
				
				Klicke auf diesen Link, um deinen Account zu aktivieren:
				'.$activationURL.'
				
				Viel Spass bei Rakuun!
				
				
				Hinweis: falls der Account nicht innerhalb der nächsten 2 Tage aktiviert wird, wird er automatisch gelöscht und du wirst keine weiteren EMails von Rakuun erhalten.
				
				---------------------------------------------------
				Rakuun - kostenloses SciFi-Browsergame
				Game: http://www.rakuun.de
				Forum: http://forum.rakuun.de
				IRC: #rakuun, Gamesurge (irc.gamesurge.net)'
			);
			$mail->send();
			$activation->hasBeenRemembered = true;
			$activation->save();
		}
		
		// LOCK NOT ACTIVATED ACCOUNTS -----------------------------------------
		$options = array();
		$options['conditions'][] = array('time < ?', time() - self::CLEANUP_NOTACTIVATED_DELETE);
		DB_Connection::get()->beginTransaction();
		foreach (Rakuun_DB_Containers::getUserActivationContainer()->select($options) as $activation) {
			Rakuun_Intern_Log_UserActivity::log($activation->user, Rakuun_Intern_Log::ACTION_ACTIVITY_LOCK_NOTACTIVATED);
			Rakuun_User_Manager::lock($activation->user);
		}
		DB_Connection::get()->commit();
	}
}

?>