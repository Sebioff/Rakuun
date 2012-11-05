<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

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
		$divider = 2;
		if (Rakuun_User_Manager::isSitting())
			$divider *= Rakuun_Intern_Production_Base::SITTER_PRODUCTION_COSTS_MULTIPLIER;
		return round($this->getIronCostsForLevel($level) / $divider);
	}
	
	/**
	 * @return int amount of ressources repayed when removing this item
	 */
	public function getBerylliumRepayForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		$divider = 2;
		if (Rakuun_User_Manager::isSitting())
			$divider *= Rakuun_Intern_Production_Base::SITTER_PRODUCTION_COSTS_MULTIPLIER;
		return round($this->getBerylliumCostsForLevel($level) / $divider);
	}
	
	/**
	 * @return int amount of ressources repayed when removing this item
	 */
	public function getEnergyRepayForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		$divider = 2;
		if (Rakuun_User_Manager::isSitting())
			$divider *= Rakuun_Intern_Production_Base::SITTER_PRODUCTION_COSTS_MULTIPLIER;
		return round($this->getEnergyCostsForLevel($level) / $divider);
	}
	
	/**
	 * @return int amount of ressources repayed when removing this item
	 */
	public function getPeopleRepayForLevel($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		$divider = 2;
		if (Rakuun_User_Manager::isSitting())
			$divider *= Rakuun_Intern_Production_Base::SITTER_PRODUCTION_COSTS_MULTIPLIER;
		return round($this->getPeopleCostsForLevel($level) / $divider);
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