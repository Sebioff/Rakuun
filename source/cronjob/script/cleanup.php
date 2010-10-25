<?php

class Rakuun_Cronjob_Script_Cleanup extends Cronjob_Script {
	const CLEANUP_INACTIVE_YIMTAY = 1814400; // 3 weeks
	const CLEANUP_INACTIVE_DELETE = 6048000; // 10 weeks
	const CLEANUP_NOTACTIVATED_REMEMBER = 86400; // 1 day
	const CLEANUP_NOTACTIVATED_DELETE = 259200; // 3 days
	
	public function execute() {
		// REMOVE INACTIVE PLAYERS ---------------------------------------------
		$options = array();
		// uses last_login instead of last_activity, because last_activity is updated by sitter as well
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
		// uses last_login instead of last_activity, because last_activity is updated by sitter as well
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
			/*$mail = new Net_Mail();
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
			$activation->save();*/
		}
		
		// REMOVE NOT ACTIVATED ACCOUNTS ---------------------------------------
		$options = array();
		$options['conditions'][] = array('time < ?', time() - self::CLEANUP_NOTACTIVATED_DELETE);
		DB_Connection::get()->beginTransaction();
		foreach (Rakuun_DB_Containers::getUserActivationContainer()->select($options) as $activation) {
			Rakuun_Intern_Log_UserActivity::log($activation->user, Rakuun_Intern_Log::ACTION_ACTIVITY_DELETE_NOTACTIVATED);
			// we can't use delete by $options here because the delete handler of the container wouldn't work
			Rakuun_User_Manager::delete($activation->user, 'Nicht aktiviert');
			Rakuun_DB_Containers::getUserActivationContainer()->delete($activation);
		}
		DB_Connection::get()->commit();
	}
}

?>