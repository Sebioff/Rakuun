<?php

/**
 * Decorator for Rakuun_Intern_Production_Unit
 */
class Rakuun_Intern_Production_WIP_Unit extends Rakuun_Intern_Production_WIP {
	// CUSTOM METHODS ----------------------------------------------------------
	/**
	 * @return int the number of finished units
	 */
	public function getAmountOfFinishedUnits() {
		return floor((time() - $this->getStartTime()) / $this->getWIPItem()->getTimeCosts(1));
	}
	
	/**
	 * @return int the time still needed to complete all units of this item
	 */
	public function getTotalRemainingTime() {
		return $this->getWIPItem()->getTimeCosts() - (time() - $this->getStartTime());
	}
	
	/**
	 * @return int the timestamp at which all units of this item will be completed
	 */
	public function getTotalTargetTime() {
		return $this->getWIPItem()->getTimeCosts() + $this->getStartTime();
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	/**
	 * @return int the time still needed to complete one unit of this item
	 */
	public function getRemainingTime() {
		return $this->getWIPItem()->getTimeCosts(1) - (time() - $this->getStartTime());
	}
	
	/**
	 * @return int the timestamp at which this the next unit of this item will be completed
	 */
	public function getTargetTime() {
		return $this->getWIPItem()->getTimeCosts(1) + $this->getStartTime();
	}
}

?>