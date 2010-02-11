<?php

class Rakuun_Intern_Production_Building_Store extends Rakuun_Intern_Production_Building {
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
		return round($this->getCapacity() / 100 * RAKUUN_STORE_CAPACITY_SAVEPERCENT);
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