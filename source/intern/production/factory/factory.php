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
 * Factory class that maps strings to buildings, technologies or units.
 */
abstract class Rakuun_Intern_Production_Factory {
	private static $buildingList = array();
	private static $technologyList = array();
	private static $unitList = array();
	
	/**
	 * @return Rakuun_Intern_Production_Building
	 */
	public static function getBuilding($internalName, DB_Record $buildingSource = null) {
		if (!self::$buildingList)
			self::generateBuildingList();
		
		if (!isset(self::$buildingList[$internalName]))
			return null;
			
		return new self::$buildingList[$internalName]($buildingSource);
	}
	
	public static function getAllBuildings(DB_Record $buildingSource = null) {
		if (!self::$buildingList)
			self::generateBuildingList();
		
		$buildingList = array();
		foreach (self::$buildingList as $internalName => $buildingClass) {
			$buildingList[] = new $buildingClass($buildingSource);
		}
		return $buildingList;
	}
	
	/**
	 * @return Rakuun_Intern_Production_Technology
	 */
	public static function getTechnology($internalName, DB_Record $technologySource = null) {
		if (!self::$technologyList)
			self::generateTechnologyList();
			
		if (!isset(self::$technologyList[$internalName]))
			return null;
			
		return new self::$technologyList[$internalName]($technologySource);
	}
	
	public static function getAllTechnologies(DB_Record $technologySource = null) {
		if (!self::$technologyList)
			self::generateTechnologyList();
		
		$technologyList = array();
		foreach (self::$technologyList as $internalName => $technologyClass) {
			$technologyList[] = new $technologyClass($technologySource);
		}
		return $technologyList;
	}
	
	/**
	 * @param $unitSource DB_Record Either a Rakuun_DB_User, null (which results
	 * in returning units for the currently logged in user) or any other DB_Record
	 * that contains amounts of units
	 * @return Rakuun_Intern_Production_Unit
	 */
	public static function getUnit($internalName, DB_Record $unitSource = null) {
		if (!self::$unitList)
			self::generateUnitList();
			
		if (!isset(self::$unitList[$internalName]))
			return null;
			
		return new self::$unitList[$internalName]($unitSource);
	}
	
	/**
	 * @param $unitSource DB_Record Either a Rakuun_DB_User, null (which results
	 * in returning units for the currently logged in user) or any other DB_Record
	 * that contains amounts of units
	 * @param $order array an array of internal unit names. The returned units will
	 * be in the same order as in the array
	 */
	public static function getAllUnits(DB_Record $unitSource = null, array $order = array()) {
		if (!self::$unitList)
			self::generateUnitList();
		
		$unitList = array();
		foreach (self::$unitList as $internalName => $unitClass) {
			$unitList[] = new $unitClass($unitSource);
		}
		
		if ($order)
			usort($unitList, array(new InternalNameComparator($order), 'compare'));
		
		return $unitList;
	}
	
	private static function addBuilding($internalName, $buildingClass) {
		self::$buildingList[$internalName] = $buildingClass;
	}
	
	private static function addTechnology($internalName, $technologyClass) {
		self::$technologyList[$internalName] = $technologyClass;
	}
	
	private static function addUnit($internalName, $unitClass) {
		self::$unitList[$internalName] = $unitClass;
	}
	
	private static function generateBuildingList() {
		self::addBuilding('ironmine', 'Rakuun_Intern_Production_Building_Ironmine');
		self::addBuilding('berylliummine', 'Rakuun_Intern_Production_Building_Berylliummine');
		self::addBuilding('ironstore', 'Rakuun_Intern_Production_Building_Ironstore');
		self::addBuilding('berylliumstore', 'Rakuun_Intern_Production_Building_Berylliumstore');
		self::addBuilding('energystore', 'Rakuun_Intern_Production_Building_Energystore');
		self::addBuilding('house', 'Rakuun_Intern_Production_Building_House');
		self::addBuilding('themepark', 'Rakuun_Intern_Production_Building_Themepark');
		self::addBuilding('clonomat', 'Rakuun_Intern_Production_Building_Clonomat');
		self::addBuilding('laboratory', 'Rakuun_Intern_Production_Building_Laboratory');
		self::addBuilding('hydropower_plant', 'Rakuun_Intern_Production_Building_HydropowerPlant');
		self::addBuilding('stock_market', 'Rakuun_Intern_Production_Building_StockMarket');
		self::addBuilding('moleculartransmitter', 'Rakuun_Intern_Production_Building_Moleculartransmitter');
		self::addBuilding('military_base', 'Rakuun_Intern_Production_Building_MilitaryBase');
		self::addBuilding('tank_factory', 'Rakuun_Intern_Production_Building_TankFactory');
		self::addBuilding('barracks', 'Rakuun_Intern_Production_Building_Barracks');
		self::addBuilding('city_wall', 'Rakuun_Intern_Production_Building_CityWall');
		self::addBuilding('airport', 'Rakuun_Intern_Production_Building_Airport');
		self::addBuilding('sensor_bay', 'Rakuun_Intern_Production_Building_SensorBay');
		self::addBuilding('shield_generator', 'Rakuun_Intern_Production_Building_ShieldGenerator');
	}
	
	private static function generateTechnologyList() {
		self::addTechnology('hydropower', 'Rakuun_Intern_Production_Technology_Hydropower');
		self::addTechnology('genetic', 'Rakuun_Intern_Production_Technology_Genetic');
		self::addTechnology('light_weaponry', 'Rakuun_Intern_Production_Technology_LightWeaponry');
		self::addTechnology('light_plating', 'Rakuun_Intern_Production_Technology_LightPlating');
		self::addTechnology('jet', 'Rakuun_Intern_Production_Technology_Jet');
		self::addTechnology('laser', 'Rakuun_Intern_Production_Technology_Laser');
		self::addTechnology('antigravitation', 'Rakuun_Intern_Production_Technology_Antigravitation');
		self::addTechnology('cloaking', 'Rakuun_Intern_Production_Technology_Cloaking');
		self::addTechnology('enhanced_cloaking', 'Rakuun_Intern_Production_Technology_EnhancedCloaking');
		self::addTechnology('momo', 'Rakuun_Intern_Production_Technology_Momo');
		self::addTechnology('supercompression', 'Rakuun_Intern_Production_Technology_Supercompression');
		self::addTechnology('plasmatechnology', 'Rakuun_Intern_Production_Technology_Plasmatechnology');
		self::addTechnology('cybernetics', 'Rakuun_Intern_Production_Technology_Cybernetics');
		self::addTechnology('sensor_technology', 'Rakuun_Intern_Production_Technology_SensorTechnology');
	}
	
	private static function generateUnitList() {
		self::addUnit('inra', 'Rakuun_Intern_Production_Unit_Inra');
		self::addUnit('laser_rifleman', 'Rakuun_Intern_Production_Unit_LaserRifleman');
		self::addUnit('lorica', 'Rakuun_Intern_Production_Unit_Lorica');
		self::addUnit('minigani', 'Rakuun_Intern_Production_Unit_Minigani');
		self::addUnit('mandrogani', 'Rakuun_Intern_Production_Unit_Mandrogani');
		self::addUnit('buhogani', 'Rakuun_Intern_Production_Unit_Buhogani');
		self::addUnit('donany', 'Rakuun_Intern_Production_Unit_Donany');
		self::addUnit('tertor', 'Rakuun_Intern_Production_Unit_Tertor');
		self::addUnit('stormok', 'Rakuun_Intern_Production_Unit_Stormok');
		self::addUnit('laser_turret', 'Rakuun_Intern_Production_Unit_LaserTurret');
		self::addUnit('spydrone', 'Rakuun_Intern_Production_Unit_Spydrone');
		self::addUnit('cloaked_spydrone', 'Rakuun_Intern_Production_Unit_CloakedSpydrone');
	}
}

class InternalNameComparator {
	private $order = array();
	
	public function __construct(array $order) {
		$this->order = $order;
	}
	
	public function compare(Rakuun_Intern_Production_Base $a, Rakuun_Intern_Production_Base $b) {
		return array_search($a->getInternalName(), $this->order) - array_search($b->getInternalName(), $this->order);
	}
}

?>