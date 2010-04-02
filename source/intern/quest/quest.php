<?php

abstract class Rakuun_Intern_Quest {
	const IDENTIFIER_FIRST_COMPLETE_MOMO = 0;
	const IDENTIFIER_FIRST_LABORATORY_10 = 1;
	const IDENTIFIER_FIRST_CAPTURED_DATABASE = 2;
	
	public function awardIfPossible(DB_Record $awardTo) {
		if ($this->canBeAwarded())
			$this->awardTo($awardTo);
	}
	
	protected function awardTo(DB_Record $awardTo) {
		if (!($questRecord = Rakuun_DB_Containers::getQuestsContainer()->selectByIdentifierFirst($this->getIdentifier()))) {
			$questRecord = new DB_Record();
			$questRecord->identifier = $this->getIdentifier();
		}
		$questRecord->owner = $awardTo->getPK();
		$questRecord->time = time();
		Rakuun_DB_Containers::getQuestsContainer()->save($questRecord);
	}
	
	public function exists() {
		return (Rakuun_DB_Containers::getQuestsContainer()->countByIdentifier($this->getIdentifier()) >= 1);
	}
	
	public function isOwnedBy(DB_Record $owner) {
		$options = array();
		$options['conditions'][] = array('owner = ?', $owner);
		$options['conditions'][] = array('identifier = ?', $this->getIdentifier());
		return (Rakuun_DB_Containers::getQuestsContainer()->count($options) >= 1);
	}
	
	public function getRecord() {
		return Rakuun_DB_Containers::getQuestsContainer()->selectByIdentifierFirst($this->getIdentifier());
	}
	
	// ABSTRACT METHODS --------------------------------------------------------
	protected abstract function getIdentifier();
	protected abstract function canBeAwarded();
	public abstract function getDescription();
	public abstract function getRewardDescription();
	public abstract function getOwnerName();
}

?>