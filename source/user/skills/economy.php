<?php

class Rakuun_Intern_Skills_Economy extends Rakuun_Intern_Skills {
	const EFFECT_VALUE = 0.01;
		
	public function raiseSkill() {
		$this->user->economy += 1;
		$this->save();
	}
	
	public function getEffectValue() {
		return ($this->user->economy * self::EFFECT_VALUE);
	}
}

?>