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
 * Base class for all producable items: buildings, technologies, units
 */
abstract class Rakuun_Intern_Production_Base {
	const ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK = 'Rakuun_Intern_Production_Base_indestructible_by_attack';
	const ATTRIBUTE_DESTRUCTIBLE_UNTIL_AVERAGE_IN_WAR = 'Rakuun_Intern_Production_Base_destructible_until_average_in_war';
	const ATTRIBUTE_INVISIBLE_FOR_SPIES = 'Rakuun_Intern_Production_Base_invisible_for_spies';
	const SITTER_PRODUCTION_COSTS_MULTIPLIER = 1.05;
	
	private $internalName = '';
	private $name = '';
	private $shortDescription = '';
	private $longDescription = '';
	private $points = 0;
	private $baseIronCosts = 0;
	private $baseBerylliumCosts = 0;
	private $baseEnergyCosts = 0;
	private $basePeopleCosts = 0;
	private $baseTimeCosts = 0;
	private $dataSource = null;
	private $owner = null;
	private $neededBuildings = array();
	private $neededTechnologies = array();
	private $neededRequirements = array();
	private $attributes = array();
	
	public function __construct(DB_Record $dataSource = null, Rakuun_Intern_Production_Owner $owner = null) {
		$this->setDataSource($dataSource);
		$this->setOwner($owner);
		
		$this->addAttribute(self::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK, false, 'Kann nicht durch Angriff zerstört werden');
		$this->addAttribute(self::ATTRIBUTE_DESTRUCTIBLE_UNTIL_AVERAGE_IN_WAR, false, 'Kann im Krieg bis zum Durchschnitt aller Spieler zerstört werden, ansonsten unzerstörbar');
		$this->addAttribute(self::ATTRIBUTE_INVISIBLE_FOR_SPIES, false, 'Unsichtbar für Spione');
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	public function getNeededBuildings() {
		return $this->neededBuildings;
	}
	
	public function addNeededBuilding($internalName, $neededLevel) {
		$this->neededBuildings[$internalName] = $neededLevel;
	}
	
	public function getNeededTechnologies() {
		return $this->neededTechnologies;
	}
	
	public function addNeededTechnology($internalName, $neededLevel) {
		$this->neededTechnologies[$internalName] = $neededLevel;
	}
	
	public function getNeededRequirements() {
		return $this->neededRequirements;
	}
	
	public function addNeededRequirement(Rakuun_Intern_Production_Requirement $requirement) {
		$requirement->setProductionItem($this);
		$this->neededRequirements[] = $requirement;
	}
	
	/**
	 * @return true if all prerequisites needed to produce this item are met
	 */
	public abstract function canBuild();
	
	public abstract function gotEnoughRessources();
	
	public function meetsTechnicalRequirements() {
		foreach ($this->neededBuildings as $internalName => $neededLevel) {
			if (Rakuun_Intern_Production_Factory::getBuilding($internalName, $this->getOwner())->getLevel() < $neededLevel)
				return false;
		}
		
		foreach ($this->neededTechnologies as $internalName => $neededLevel) {
			if (Rakuun_Intern_Production_Factory::getTechnology($internalName, $this->getOwner())->getLevel() < $neededLevel)
				return false;
		}
		
		foreach ($this->neededRequirements as $requirement) {
			if (!$requirement->fulfilled())
				return false;
		}
		
		return true;
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getInternalName() {
		return $this->internalName;
	}
	
	/**
	 * Unique name used to identify this item
	 * Needs to match with the database-name
	 */
	public function setInternalName($internalName) {
		$this->internalName = $internalName;
	}
	
	/**
	 * The name of this item, as visible in the game
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * The name of this item, as visible in the game
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getShortDescription() {
		return $this->shortDescription;
	}
	
	public function setShortDescription($shortDescription) {
		$this->shortDescription = $shortDescription;
	}
	
	public function getLongDescription() {
		return $this->longDescription;
	}
	
	public function setLongDescription($longDescription) {
		$this->longDescription = $longDescription;
	}
	
	public function getBaseIronCosts() {
		$costs = $this->baseIronCosts;
		if (Rakuun_User_Manager::isSitting())
			$costs *= self::SITTER_PRODUCTION_COSTS_MULTIPLIER;
		return round($costs);
	}
	
	public function setBaseIronCosts($baseIronCosts) {
		$this->baseIronCosts = $baseIronCosts;
	}
	
	public function getBaseBerylliumCosts() {
		$costs = $this->baseBerylliumCosts;
		if (Rakuun_User_Manager::isSitting())
			$costs *= self::SITTER_PRODUCTION_COSTS_MULTIPLIER;
		return round($costs);
	}
	
	public function setBaseBerylliumCosts($baseBerylliumCosts) {
		$this->baseBerylliumCosts = $baseBerylliumCosts;
	}
	
	public function getBaseEnergyCosts() {
		$costs = $this->baseEnergyCosts;
		if (Rakuun_User_Manager::isSitting())
			$costs *= self::SITTER_PRODUCTION_COSTS_MULTIPLIER;
		return round($costs);
	}
	
	public function setBaseEnergyCosts($baseEnergyCosts) {
		$this->baseEnergyCosts = $baseEnergyCosts;
	}
	
	public function getBasePeopleCosts() {
		$costs = $this->basePeopleCosts;
		if (Rakuun_User_Manager::isSitting())
			$costs *= self::SITTER_PRODUCTION_COSTS_MULTIPLIER;
		return round($costs);
	}
	
	public function setBasePeopleCosts($basePeopleCosts) {
		$this->basePeopleCosts = $basePeopleCosts;
	}
	
	public function getBaseTimeCosts() {
		return $this->baseTimeCosts;
	}
	
	/**
	 * Sets the costs for the lowest level of this building in seconds
	 */
	public function setBaseTimeCosts($baseTimeCosts) {
		$this->baseTimeCosts = $baseTimeCosts;
	}
	
	/**
	 * @return DB_Record
	 */
	public function getDataSource() {
		return $this->dataSource;
	}
	
	public function setDataSource($dataSource) {
		$this->dataSource = $dataSource;
	}
	
	/**
	 * @return Rakuun_Intern_Production_Owner
	 */
	public function getOwner() {
		return $this->owner;
	}
	
	public function setOwner($owner) {
		$this->owner = $owner;
	}
	
	public function getNeededTechnology($internalName) {
		if (isset($this->neededTechnologies[$internalName]))
			return $this->neededTechnologies[$internalName];
		else
			return 0;
	}
	
	public function getNeededBuilding($internalName) {
		if (isset($this->neededBuildings[$internalName]))
			return $this->neededBuildings[$internalName];
		else
			return 0;
	}
	
	public function setPoints($points) {
		$this->points = $points;
	}
	
	public function getPoints() {
		return $this->points;
	}
	
	public function getType() {
		if ($this instanceof Rakuun_Intern_Production_Building)
			return 'building';
		elseif ($this instanceof Rakuun_Intern_Production_Technology)
			return 'technology';
		elseif ($this instanceof Rakuun_Intern_Production_Unit)
			return 'unit';
	}
	
	public function addAttribute($attributeIdentifier, $defaultValue, $description = '') {
		if (!is_bool($defaultValue))
			throw new Core_Exception('$defaultValue must be boolean.');
		
		$this->attributes[$attributeIdentifier] = array(
			'value' => $defaultValue,
			'description' => $description
		);
	}
	
	public function setAttribute($attributeIdentifier, $value) {
		if (!is_bool($value))
			throw new Core_Exception('$value must be boolean.');
		
		$this->attributes[$attributeIdentifier]['value'] = $value;
	}
	
	public function getAttribute($attributeIdentifier) {
		return $this->attributes[$attributeIdentifier]['value'];
	}
	
	public function getAttributeDescription($attributeIdentifier) {
		return $this->attributes[$attributeIdentifier]['description'];
	}
	
	public function getAttributes() {
		return $this->attributes;
	}
}

?>