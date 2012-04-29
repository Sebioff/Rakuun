<?php

class Rakuun_Intern_Quest_FirstHighLaboratory extends Rakuun_Intern_Quest {
	const REQUIRED_LABORATORY_LEVEL = 20;
	
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
		return 'Baue als Erster Forschungslabor Stufe '.self::REQUIRED_LABORATORY_LEVEL.'!';
	}
	
	public function getRewardDescription() {
		return 'Verbesserte Tarnung Stufe 1';
	}
	
	public function getOwnerName() {
		if ($owner = Rakuun_DB_Containers::getUserContainer()->selectByPK($this->getRecord()->owner))
			return $owner->nameUncolored;
		else
			return Rakuun_DB_Containers::getUserDeletedContainer()->selectByIDFirst($this->getRecord()->owner)->nameUncolored;
	}
}

?>