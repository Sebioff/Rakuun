<?php

class Rakuun_Intern_Achievements_Round25Adapter extends Rakuun_Intern_Achievements_Round24Adapter {
	protected function addAchievements(DB_Record $user, DB_Record $eternalUser, $roundName) {
		parent::addAchievements($user, $eternalUser, $roundName);
		
		// member of winning meta
		$alliance = Rakuun_DB_Containers_Persistent::getAlliancesContainer()->selectByPK($user->alliance);
		if ($alliance) {
			$meta = Rakuun_DB_Containers_Persistent::getMetasContainer()->selectByPK($alliance->meta);
			if ($meta && $meta->name == $this->getRoundInformation($roundName)->winningMeta)
				$this->saveAchievement($eternalUser, $roundName, 'Mitglied der Siegermeta');
		}
	}
}