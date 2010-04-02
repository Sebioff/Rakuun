<?php

class Rakuun_Intern_Quest_FirstLaboratory10 extends Rakuun_Intern_Quest {
	protected function awardTo(DB_Record $awardTo) {
		parent::awardTo($awardTo);
		
		if ($awardTo->technologies->enhancedCloaking < 1) {
			$awardTo->technologies->enhancedCloaking = 1;
			$awardTo->technologies->save();
		}
	}
	
	protected function canBeAwarded() {
		return (!$this->exists());
	}
	
	protected function getIdentifier() {
		return Rakuun_Intern_Quest::IDENTIFIER_FIRST_LABORATORY_10;
	}
	
	public function getDescription() {
		return 'Baue als Erster Forschungslabor Stufe 10!';
	}
	
	public function getRewardDescription() {
		return 'Verbesserte Tarnung Stufe 1';
	}
	
	public function getOwnerName() {
		return Rakuun_DB_Containers::getUserContainer()->selectByPK($this->getRecord()->owner)->name;
	}
}

?>