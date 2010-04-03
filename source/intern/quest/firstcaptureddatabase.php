<?php

class Rakuun_Intern_Quest_FirstCapturedDatabase extends Rakuun_Intern_Quest {
	protected function awardTo(DB_Record $awardTo) {
		if ($awardTo->alliance) {
			parent::awardTo($awardTo->alliance);
			
			$awardTo->alliance->raise(10000, 10000, 2000);
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
		return '10.000 Eisen, 10.000 Beryllium und 2.000 Energie in die Allianzkasse';
	}
	
	public function getOwnerName() {
		return Rakuun_DB_Containers::getAlliancesContainer()->selectByPK($this->getRecord()->owner)->name;
	}
}

?>