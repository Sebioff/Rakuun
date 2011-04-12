<?php

class Rakuun_Intern_Quest_FirstCompleteMomo extends Rakuun_Intern_Quest {
	const BUILD_TIME_REDUCTION_PERCENT = 50;
	
	protected function canBeAwarded() {
		return (!$this->exists());
	}
	
	protected function getIdentifier() {
		return Rakuun_Intern_Quest::IDENTIFIER_FIRST_COMPLETE_MOMO;
	}
	
	public function getDescription() {
		return 'Erforsche als Erster den MoMo vollständig!';
	}
	
	public function getRewardDescription() {
		return self::BUILD_TIME_REDUCTION_PERCENT.'% Verkürzung der Bauzeit von Gebäuden';
	}
	
	public function getOwnerName() {
		if ($owner = Rakuun_DB_Containers::getUserContainer()->selectByPK($this->getRecord()->owner))
			return $owner->nameUncolored;
		else
			return Rakuun_DB_Containers::getUserDeletedContainer()->selectByIDFirst($this->getRecord()->owner)->nameUncolored;
	}
}

?>