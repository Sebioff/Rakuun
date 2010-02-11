<?php

class Rakuun_DB_Ressources extends DB_Record {
	/**
	 * Lowers the ressources. Note that you can't lower the ressources below 0.
	 */
	public function lower($iron, $beryllium = 0, $energy = 0, $people = 0) {
		if ($this->iron - $iron < 0)
			$iron = $this->iron;
		if ($this->beryllium - $beryllium < 0)
			$beryllium = $this->beryllium;
		if ($this->energy - $energy < 0)
			$energy = $this->energy;
		if ($this->people - $people < 0)
			$people = $this->people;
		$this->iron -= $iron;
		$this->beryllium -= $beryllium;
		$this->energy -= $energy;
		$this->people -= $people;
		$this->save();
	}
	
	/**
	 * Raises the ressources. Note that you can't raise the ressources higher than
	 * the store capacity.
	 */
	public function raise($iron, $beryllium = 0, $energy = 0, $people = 0) {
		if ($iron > 0 && $iron + $this->iron > $this->getCapacityIron())
	 		$iron = $this->getCapacityIron() - $this->iron;
		if ($beryllium > 0 && $beryllium + $this->beryllium > $this->getCapacityBeryllium())
	 		$beryllium = $this->getCapacityBeryllium() - $this->beryllium;
		if ($energy > 0 && $energy + $this->energy > $this->getCapacityEnergy())
	 		$energy = $this->getCapacityEnergy() - $this->energy;
	 	if ($people > 0 && $people + $this->people > $this->getCapacityPeople())
	 		$people = $this->getCapacityPeople() - $this->people;
		$this->iron += $iron;
		$this->beryllium += $beryllium;
		$this->energy += $energy;
		$this->people += $people;
		$this->save();
	}
	
	/**
	 * @return boolean true if there is enough store capacity for the given ressources,
	 * false otherwhise
	 */
	public function gotEnoughCapacity($iron, $beryllium = 0, $energy = 0, $people = 0) {
		return ($this->iron + $iron <= $this->getCapacityIron()
				&& $this->beryllium + $beryllium <= $this->getCapacityBeryllium()
				&& $this->energy + $energy <= $this->getCapacityEnergy()
				&& $this->people + $people <= $this->getCapacityPeople());
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getCapacityIron() {
		return Rakuun_Intern_Production_Factory::getBuilding('ironstore', $this->user)->getCapacity();
	}
	
	public function getCapacityBeryllium() {
		return Rakuun_Intern_Production_Factory::getBuilding('berylliumstore', $this->user)->getCapacity();
	}
	
	public function getCapacityEnergy() {
		return Rakuun_Intern_Production_Factory::getBuilding('energystore', $this->user)->getCapacity();
	}
	
	public function getCapacityPeople() {
		return Rakuun_Intern_Production_Factory::getBuilding('house', $this->user)->getCapacity();
	}
	
	public function getSaveCapacityIron() {
		return Rakuun_Intern_Production_Factory::getBuilding('ironstore', $this->user)->getSaveCapacity();
	}
	
	public function getSaveCapacityBeryllium() {
		return Rakuun_Intern_Production_Factory::getBuilding('berylliumstore', $this->user)->getSaveCapacity();
	}
	
	public function getSaveCapacityEnergy() {
		return Rakuun_Intern_Production_Factory::getBuilding('energystore', $this->user)->getSaveCapacity();
	}
	
	public function getSaveCapacityPeople() {
		return Rakuun_Intern_Production_Factory::getBuilding('house', $this->user)->getSaveCapacity();
	}
}

?>