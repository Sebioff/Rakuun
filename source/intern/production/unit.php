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
 * Base class for all military units
 */
abstract class Rakuun_Intern_Production_Unit extends Rakuun_Intern_Production_UserItem {
	// TODO add pezetto to end of list if pezettos get implemented
	const DEFAULT_DEFENSE_SEQUENCE = 'tertor|inra|donany|stormok|mandrogani|laser_rifleman|lorica|minigani|buhogani|laser_turret';
	const DEFAULT_ATTACK_SEQUENCE = 'tertor|inra|donany|stormok|mandrogani|laser_rifleman|lorica|minigani|buhogani';
	
	const TYPE_FOOTSOLDIER = 1; // binary 0001
	const TYPE_VEHICLE = 2; // binary 0010
	const TYPE_AIRCRAFT = 4; // binary 0100
	const TYPE_STATIONARY = 8; // binary 1000
	
	const BONUS_PERCENT_VEHICLE_VS_FOOTSOLDIER = 25;
	const BONUS_PERCENT_AIRCRAFT_VS_FOOTSOLDIER = 0;
	const BONUS_PERCENT_STATIONARY_VS_FOOTSOLDIER = 0;
	const BONUS_PERCENT_FOOTSOLDIER_VS_VEHICLE = 0;
	const BONUS_PERCENT_AIRCRAFT_VS_VEHICLE = 25;
	const BONUS_PERCENT_STATIONARY_VS_VEHICLE = 0;
	const BONUS_PERCENT_FOOTSOLDIER_VS_AIRCRAFT = 25;
	const BONUS_PERCENT_VEHICLE_VS_AIRCRAFT = 0;
	const BONUS_PERCENT_STATIONARY_VS_AIRCRAFT = 0;
	
	const ATTRIBUTE_CLOAKING = 'Rakuun_Intern_Production_Unit_cloaking';
	const ATTRIBUTE_MOVE_OVER_WATER = 'Rakuun_Intern_Production_Unit_move_over_water';
	
	private $amount = null;
	private $baseAttackValue = 0;
	private $baseDefenseValue = 0;
	private $ressourceTransportCapacity = 0;
	private $namePlural = '';
	private $unitType = 0;
	private $baseSpeed = 1;
	
	public function __construct(DB_Record $dataSource = null) {
		$user = null;
		if (!$dataSource) {
			if ($user = Rakuun_User_Manager::getCurrentUser())
				$dataSource = $user->units;
		}
		elseif ($dataSource instanceof Rakuun_DB_User) {
			$user = $dataSource;
			$dataSource = $dataSource->units;
		}
		else {
			$user = $dataSource->user;
		}
		parent::__construct($dataSource, $user);
		
		$this->addAttribute(self::ATTRIBUTE_CLOAKING, false, 'Diese Einheit kann sich tarnen');
		$this->addAttribute(self::ATTRIBUTE_MOVE_OVER_WATER, false, 'Diese Einheit kann sich über Wasser bewegen');
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	public function getNameForAmount($amount = null) {
		if ($amount === null)
			$amount = $this->getAmount();
		if ($amount == 1)
			return $this->getName();
		else
			return $this->getNamePlural();
	}
	
	public function getIronCostsForAmount($amount) {
		return $this->getBaseIronCosts() * $amount;
	}
	
	public function getBerylliumCostsForAmount($amount) {
		return $this->getBaseBerylliumCosts() * $amount;
	}
	
	public function getEnergyCostsForAmount($amount) {
		return $this->getBaseEnergyCosts() * $amount;
	}
	
	public function getPeopleCostsForAmount($amount) {
		return $this->getBasePeopleCosts() * $amount;
	}
	
	public function getIronRepayForAmount($amount = null) {
		if ($amount === null)
			$amount = $this->getAmount();
		return round($this->getIronCostsForAmount($amount) / 2);
	}
	
	public function getBerylliumRepayForAmount($amount = null) {
		if ($amount === null)
			$amount = $this->getAmount();
		return round($this->getBerylliumCostsForAmount($amount) / 2);
	}
	
	public function getEnergyRepayForAmount($amount = null) {
		if ($amount === null)
			$amount = $this->getAmount();
		return round($this->getEnergyCostsForAmount($amount) / 2);
	}
	
	public function getPeopleRepayForAmount($amount = null) {
		if ($amount === null)
			$amount = $this->getAmount();
		return round($this->getPeopleCostsForAmount($amount) / 2);
	}
	
	public function getTimeCosts($amount = null) {
		if ($amount === null)
			$amount = $this->getAmount();
		
		$timeCosts = $this->getBaseTimeCosts();
		$reductionPercent = 0;
		if ($this->getNeededBuilding('military_base') > 0)
			$reductionPercent += Rakuun_Intern_Production_Building_MilitaryBase::PRODUCTION_TIME_REDUCTION_PERCENT * Rakuun_Intern_Production_Factory::getBuilding('military_base', $this->getDataSource()->buildings)->getLevel();
		if ($this->getNeededBuilding('barracks') > 0)
			$reductionPercent += Rakuun_Intern_Production_Building_Barracks::PRODUCTION_TIME_REDUCTION_PERCENT * Rakuun_Intern_Production_Factory::getBuilding('barracks', $this->getDataSource()->buildings)->getLevel();
		if ($this->getNeededBuilding('tank_factory') > 0)
			$reductionPercent += Rakuun_Intern_Production_Building_TankFactory::PRODUCTION_TIME_REDUCTION_PERCENT * Rakuun_Intern_Production_Factory::getBuilding('tank_factory', $this->getDataSource()->buildings)->getLevel();
		if ($this->getNeededBuilding('airport') > 0)
			$reductionPercent += Rakuun_Intern_Production_Building_Airport::PRODUCTION_TIME_REDUCTION_PERCENT * Rakuun_Intern_Production_Factory::getBuilding('airport', $this->getDataSource()->buildings)->getLevel();
		
		$productionDatabase = new Rakuun_User_Specials_Database($this->getUser(), Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW);
		if ($productionDatabase->hasSpecial()) {
			$reductionPercent += $productionDatabase->getEffectValue() * 100;
		}
			
		if ($reductionPercent > 100)
			$reductionPercent = 100;
		if ($reductionPercent > 0)
			$timeCosts -= $timeCosts / 100 * $reductionPercent;
			
		$timeCosts = round($timeCosts / RAKUUN_SPEED_UNITPRODUCTION);
		if ($timeCosts < 1)
			$timeCosts = 1;
		
		return $timeCosts * $amount;
	}
		
	/**
	 * @return true if all prerequisites needed to produce this item are met
	 */
	public function canBuild($amount = 0) {
		return ($this->gotEnoughRessources($amount) && $this->meetsTechnicalRequirements());
	}
	
	public function gotEnoughRessources($amount = 0) {
		$ressources = $this->getUser()->ressources;
		return ($this->getIronCostsForAmount($amount) <= $ressources->iron
		 && $this->getBerylliumCostsForAmount($amount) <= $ressources->beryllium
		 && $this->getEnergyCostsForAmount($amount) <= $ressources->energy
		 && $this->getPeopleCostsForAmount($amount) <= $ressources->people);
	}
	
	public function getAttackValue($amount = null) {
		if ($amount === null)
			$amount = $this->getAmount();
		
		$baseValue = $this->baseAttackValue;
		$value = $baseValue;
		
		if ($this->getUser()) {
			$attackDatabase = new Rakuun_User_Specials_Database($this->getUser(), Rakuun_User_Specials::SPECIAL_DATABASE_RED);
			if ($attackDatabase->hasSpecial()) {
				$value += $baseValue * $attackDatabase->getEffectValue();
			}
		}
			
		return $value * $amount;
	}
	
	public function getDefenseValue($amount = null) {
		if ($amount === null)
			$amount = $this->getAmount();
		
		$baseValue = $this->baseDefenseValue;
		$value = $baseValue;
		
		$value += $baseValue / 100 * Rakuun_Intern_Production_Building_CityWall::DEFENSE_BONUS_PERCENT * Rakuun_Intern_Production_Factory::getBuilding('city_wall', $this->getDataSource()->buildings)->getLevel();
		
		if ($this->getUser()) {
			if (($databaseCount = $this->getUser()->getDatabaseCount()) > 0) {
				$value += $baseValue * Rakuun_User_Specials::EFFECTVALUE_DATABASE_DEFENSE * $databaseCount;
			}
			
			$defenseDatabase = new Rakuun_User_Specials_Database($this->getUser(), Rakuun_User_Specials::SPECIAL_DATABASE_GREEN);
			if ($defenseDatabase->hasSpecial()) {
				$value += $baseValue * $defenseDatabase->getEffectValue();
			}
		}
		
		return $value * $amount;
	}
	
	public function isOfUnitType($unitType) {
		return self::containsUnitType($this->unitType, $unitType);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getAmount() {
		if ($this->amount === null) {
			$dataSource = $this->getDataSource();
			return $dataSource->{Text::underscoreToCamelCase($this->getInternalName())};
		}
		else {
			return $this->amount;
		}
	}
	
	public function setAmount($amount) {
		$this->amount = $amount;
	}
	
	public function getNamePlural() {
		return $this->namePlural;
	}
	
	public function setNamePlural($namePlural) {
		$this->namePlural = $namePlural;
	}
	
	/**
	 * Units can be of multiple types - just call this method multiple times
	 * with different types to assign it to different unit types.
	 * @param $unitType see constants beginning with TYPE_
	 */
	public function setUnitType($unitType) {
		$this->unitType = self::getJoinedUnitType($this->unitType, $unitType);
	}
	
	/**
	 * NOTE: use isOfUnitType() to test if this unit is of a specific type.
	 * @return int integer with combined binary TYPE_ flags
	 */
	public function getUnitType() {
		return $this->unitType;
	}
	
	public function setBaseAttackValue($baseAttackValue) {
		$this->baseAttackValue = $baseAttackValue;
	}
	
	public function getBaseAttackValue() {
		return $this->baseAttackValue;
	}
	
	public function setBaseDefenseValue($baseDefenseValue) {
		$this->baseDefenseValue = $baseDefenseValue;
	}
	
	public function getBaseDefenseValue() {
		return $this->baseDefenseValue;
	}
	
	/**
	 * @return float army strength without any boni for technologies etc.
	 */
	public function getBaseArmyStrength() {
		return ($this->getBaseAttackValue() + $this->getBaseDefenseValue()) / 2;
	}
	
	/**
	 * @return float army strength including all types of boni.
	 */
	public function getArmyStrength($amount = null) {
		if ($amount === null)
			$amount = $this->getAmount();
		
		return ($this->getAttackValue($amount) + $this->getDefenseValue($amount)) / 2;
	}
	
	public function setRessourceTransportCapacity($ressourceTransportCapacity) {
		$this->ressourceTransportCapacity = $ressourceTransportCapacity;
	}
	
	public function getRessourceTransportCapacity($amount = null) {
		if ($amount === null)
			$amount = $this->getAmount();
		
		return $this->ressourceTransportCapacity * $amount;
	}
	
	public function getAttackValueAgainst($unitType, $amount = null) {
		$attackValue = $this->getAttackValue($amount);
		$boniPercent = $this->getBoniPercentAgainst($unitType);
		
		if ($boniPercent != 0)
			$attackValue += $attackValue / 100 * $boniPercent;
		
		return $attackValue;
	}
	
	public function getDefenseValueAgainst($unitType, $amount = null) {
		$defenseValue = $this->getDefenseValue($amount);
		$boniPercent = $this->getBoniPercentAgainst($unitType);
		
		if ($boniPercent != 0)
			$defenseValue += $defenseValue / 100 * $boniPercent;
		
		return $defenseValue;
	}
	
	public function getAmountInProduction() {
		$options = array();
		$options['properties'] = 'SUM(amount)';
		$options['conditions'][] = array('user = ?', $this->getUser());
		$options['conditions'][] = array('unit = ?', $this->getInternalName());
		$result = Rakuun_DB_Containers::getUnitsWIPContainer()->selectFirst($options)->getAllProperties();
		return (int)array_shift($result);
	}
	
	public function getAmountNotAtHome() {
		if ($this->isOfUnitType(self::TYPE_STATIONARY))
			return 0;
		
		$options = array();
		$options['properties'] = 'SUM('.$this->getInternalName().') AS `amount`';
		$options['conditions'][] = array('user = ?', $this->getUser());
		$result = Rakuun_DB_Containers::getArmiesContainer()->selectFirst($options);
		return $result ? $result->amount : 0;
	}
	
	/**
	 * The points this unit gets in highscores (e.g. end-highscore)
	 * Override function getPoints() from upperclass
	 * @see source/intern/production/Rakuun_Intern_Production_Base#getPoints()
	 */
	public function getPoints() {
		return $this->getBaseArmyStrength();
	}
	
	protected function getBoniPercentAgainst($unitType) {
		$boniPercent = 0;
		
		if ($this->isOfUnitType(self::TYPE_FOOTSOLDIER)) {
			if (self::containsUnitType($unitType, self::TYPE_VEHICLE))
				$boniPercent += self::BONUS_PERCENT_FOOTSOLDIER_VS_VEHICLE;
			if (self::containsUnitType($unitType, self::TYPE_AIRCRAFT))
				$boniPercent += self::BONUS_PERCENT_FOOTSOLDIER_VS_AIRCRAFT;
		}
		
		if ($this->isOfUnitType(self::TYPE_VEHICLE)) {
			if (self::containsUnitType($unitType, self::TYPE_FOOTSOLDIER))
				$boniPercent += self::BONUS_PERCENT_VEHICLE_VS_FOOTSOLDIER;
			if (self::containsUnitType($unitType, self::TYPE_AIRCRAFT))
				$boniPercent += self::BONUS_PERCENT_VEHICLE_VS_AIRCRAFT;
		}
		
		if ($this->isOfUnitType(self::TYPE_AIRCRAFT)) {
			if (self::containsUnitType($unitType, self::TYPE_FOOTSOLDIER))
				$boniPercent += self::BONUS_PERCENT_AIRCRAFT_VS_FOOTSOLDIER;
			if (self::containsUnitType($unitType, self::TYPE_VEHICLE))
				$boniPercent += self::BONUS_PERCENT_AIRCRAFT_VS_VEHICLE;
		}
		
		if ($this->isOfUnitType(self::TYPE_STATIONARY)) {
			if (self::containsUnitType($unitType, self::TYPE_FOOTSOLDIER))
				$boniPercent += self::BONUS_PERCENT_STATIONARY_VS_FOOTSOLDIER;
			if (self::containsUnitType($unitType, self::TYPE_VEHICLE))
				$boniPercent += self::BONUS_PERCENT_STATIONARY_VS_VEHICLE;
			if (self::containsUnitType($unitType, self::TYPE_AIRCRAFT))
				$boniPercent += self::BONUS_PERCENT_STATIONARY_VS_AIRCRAFT;
		}
		
		return $boniPercent;
	}
	
	public static function getJoinedUnitType($unitType1/*, $unitType2, ... */) {
		$joinedUnitType = 0;
		foreach (func_get_args() as $unitType) {
			$joinedUnitType |= $unitType;
		}
		return $joinedUnitType;
	}
	
	public static function containsUnitType($unitTypeHaystack, $unitTypeNeedle) {
		return (($unitTypeHaystack & $unitTypeNeedle) == $unitTypeNeedle);
	}
	
	/**
	 * @return DB_Record
	 */
	public function getUnitSource() {
		return $this->unitSource;
	}
	
	public function setUnitSource(DB_Record $unitSource) {
		return $this->unitSource = $unitSource;
	}
	
	public function getBaseSpeed() {
		return $this->baseSpeed;
	}
	
	/**
	 * @param $speed time in seconds this unit requires to move from one field to
	 * another (the higher the slower)
	 */
	public function setBaseSpeed($baseSpeed) {
		$this->baseSpeed = $baseSpeed;
	}
	
	/**
	 * @return int time in seconds this unit requires to move from one field to
	 * another (the higher the slower)
	 */
	public function getSpeed() {
		return $this->baseSpeed;
	}
}

?>