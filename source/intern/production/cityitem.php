<?php

/**
 * Base class for buildings and technologies
 */
abstract class Rakuun_Intern_Production_CityItem extends Rakuun_Intern_Production_UserItem {
	private $maximumLevel = -1;
	private $minimumLevel = 0;
	private $level = null;
	private $effects = array();
	
	// CUSTOM METHODS ----------------------------------------------------------
	public function getIronCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return $this->getBaseIronCosts() * $level;
	}
	
	public function getBerylliumCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return $this->getBaseBerylliumCosts() * $level;
	}
	
	public function getEnergyCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return $this->getBaseEnergyCosts() * $level;
	}
	
	public function getPeopleCostsForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return $this->getBasePeopleCosts() * $level;
	}
	
	public function getTimeCosts($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		$costs = round($this->getBaseTimeCosts() * $level / RAKUUN_SPEED_BUILDING);
		if ($costs < 1)
			$costs = 1;
		return $costs;
	}
	
	/**
	 * @return int amount of ressources repayed when removing this item
	 */
	public function getIronRepayForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round($this->getIronCostsForLevel($level) / 2);
	}
	
	/**
	 * @return int amount of ressources repayed when removing this item
	 */
	public function getBerylliumRepayForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round($this->getBerylliumCostsForLevel($level) / 2);
	}
	
	/**
	 * @return int amount of ressources repayed when removing this item
	 */
	public function getEnergyRepayForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round($this->getEnergyCostsForLevel($level) / 2);
	}
	
	/**
	 * @return int amount of ressources repayed when removing this item
	 */
	public function getPeopleRepayForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		return round($this->getPeopleCostsForLevel($level) / 2);
	}
	
	/**
	 * @return true if all prerequisites needed to produce this item are met
	 */
	public function canBuild() {
		return (!$this->reachedMaximumLevel() && $this->gotEnoughRessources() && $this->meetsTechnicalRequirements());
	}
	
	public function getNextBuildableLevel() {
		return $this->getLevel() + $this->getFutureLevels() + 1;
	}
	
	public function reachedMaximumLevel() {
		$nextBuildableLevel = $this->getNextBuildableLevel();
		return ($nextBuildableLevel > $this->getMaximumLevel() && $this->getMaximumLevel() > 0);
	}
	
	public function gotEnoughRessources() {
		$nextBuildableLevel = $this->getNextBuildableLevel();
		$ressources = $this->getUser()->ressources;
		return ($this->getIronCostsForLevel($nextBuildableLevel) <= $ressources->iron
		 && $this->getBerylliumCostsForLevel($nextBuildableLevel) <= $ressources->beryllium
		 && $this->getEnergyCostsForLevel($nextBuildableLevel) <= $ressources->energy
		 && $this->getPeopleCostsForLevel($nextBuildableLevel) <= $ressources->people);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getLevel() {
		if ($this->level === null) {
			$dataSource = $this->getDataSource();
			return $dataSource->{Text::underscoreToCamelCase($this->getInternalName())};
		}
		else {
			return $this->level;
		}
	}
	
	public function setLevel($level) {
		$this->level = $level;
	}
	
	/**
	 * Returns the amount of levels that are currently being build.
	 */
	public abstract function getFutureLevels();
	
	/**
	 * Implement this function to define effects for this item.
	 */
	protected function defineEffects() { }
	
	/**
	 * Returns the maximum buildable level.
	 */
	public function getMaximumLevel() {
		return $this->maximumLevel;
	}
	
	public function setMaximumLevel($maximumLevel) {
		$this->maximumLevel = $maximumLevel;
	}
	
	/**
	 * Returns the minimum level this item can reach.
	 */
	public function getMinimumLevel() {
		return $this->minimumLevel;
	}
	
	public function setMinimumLevel($minimumLevel) {
		$this->minimumLevel = $minimumLevel;
	}
	
	public function getEffects() {
		if (!$this->effects)
			$this->defineEffects();
		
		return $this->effects;
	}
	
	/**
	 * Adds an effect. This is just a text string that is being displayed in this
	 * items' description. E.g.: "Raises amount of storable iron by 5000"
	 */
	public function addEffect($effect) {
		$this->effects[] = $effect;
	}
}

?>