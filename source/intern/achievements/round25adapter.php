<?php

class Rakuun_Intern_Achievements_Round25Adapter extends Rakuun_Intern_Achievements_Round24Adapter {
	protected function addAchievements(DB_Record $user, DB_Record $eternalUser, $roundName) {
		parent::addAchievements($user, $eternalUser, $roundName);
		
		// member of winning meta
		if ($user->alliance) {
			$alliance = $this->getRoundContainer('alliances', $roundName)->selectByIDFirst($user->alliance);
			$meta = $this->getRoundContainer('metas', $roundName)->selectByIDFirst($alliance->meta);
			if ($meta && $meta->name == $this->getRoundInformation($roundName)->winningMeta)
				$this->saveAchievement($eternalUser, $roundName, 'Mitglied der Siegermeta');
		}
	}
}