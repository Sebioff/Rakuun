<?php

class Rakuun_Intern_Production_Building_Store extends Rakuun_Intern_Production_Building {
	const SAVE_CAPACITY_RAISE_PER_WEEK = 1000;
	
	private $baseCapacity = 0;
	
	public function __construct($dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK, true);
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	public function getCapacity($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return $level * $this->getBaseCapacity() * RAKUUN_STORE_CAPACITY_MULTIPLIER;
	}
	
	public function getSaveCapacity() {
		return round(((time() - RAKUUN_ROUND_STARTTIME) * self::SAVE_CAPACITY_RAISE_PER_WEEK / 7 / 24 / 60 / 60 + self::SAVE_CAPACITY_RAISE_PER_WEEK) * RAKUUN_STORE_CAPACITY_SAVE_MULTIPLIER);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getBaseCapacity() {
		return $this->baseCapacity;
	}
	
	public function setBaseCapacity($baseCapacity) {
		$this->baseCapacity = $baseCapacity;
	}
}

?>