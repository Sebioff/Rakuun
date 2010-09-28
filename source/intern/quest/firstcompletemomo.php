<?php

class Rakuun_Intern_Quest_FirstCompleteMomo extends Rakuun_Intern_Quest {
	const BUILD_TIME_REDUCTION_PERCENT = 4;
	
	protected function canBeAwarded() {
		return (!$this->exists());
	}
	
	protected function getIdentifier() {
		return Rakuun_Intern_Quest::IDENTIFIER_FIRST_COMPLETE_MOMO;
	}
	
	public function getDescription() {
		return 'Baue als Erster den MoMo vollständig aus!';
	}
	
	public function getRewardDescription() {
		return '4% Verkürzung der Bauzeit von Gebäuden';
	}
	
	public function getOwnerName() {
		if ($owner = Rakuun_DB_Containers::getUserContainer()->selectByPK($this->getRecord()->owner))
			return $owner->nameUncolored;
		else
			return Rakuun_DB_Containers::getUserDeletedContainer()->selectByIDFirst($this->getRecord()->owner)->nameUncolored;
	}
}

?>