<?php

class Rakuun_Intern_Quest_FirstCapturedDatabase extends Rakuun_Intern_Quest {
	const REWARD_IRON = 10000;
	const REWARD_BERYLLIUM = 10000;
	const REWARD_ENERGY = 2000;
	
	protected function awardTo(DB_Record $awardTo) {
		if ($awardTo->alliance) {
			parent::awardTo($awardTo->alliance);
			
			$awardTo->alliance->raise(self::REWARD_IRON, self::REWARD_BERYLLIUM, self::REWARD_ENERGY);
			
			// add alliance ressource log entry
			$log = new DB_Record();
			$log->alliance = $awardTo->alliance;
			$log->iron = self::REWARD_IRON;
			$log->beryllium = self::REWARD_BERYLLIUM;
			$log->energy = self::REWARD_ENERGY;
			$log->date = time();
			$log->type = Rakuun_Intern_GUI_Panel_Alliance_Account::TYPE_ALLIANCE_QUEST;
			Rakuun_DB_Containers::getAlliancesAccountlogContainer()->save($log);
		}
	}
	
	protected function canBeAwarded() {
		return (!$this->exists());
	}
	
	protected function getIdentifier() {
		return Rakuun_Intern_Quest::IDENTIFIER_FIRST_CAPTURED_DATABASE;
	}
	
	public function getDescription() {
		return 'Erobere als Erster ein Datenbankteil für deine Allianz!';
	}
	
	public function getRewardDescription() {
		return GUI_Panel_Number::formatNumber(self::REWARD_IRON).' Eisen, '.GUI_Panel_Number::formatNumber(self::REWARD_BERYLLIUM).' Beryllium und '.GUI_Panel_Number::formatNumber(self::REWARD_ENERGY).' Energie in die Allianzkasse';
	}
	
	public function getOwnerName() {
		return Rakuun_DB_Containers::getAlliancesContainer()->selectByPK($this->getRecord()->owner)->name;
	}
}

?>