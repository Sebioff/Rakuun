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

class Rakuun_Intern_Production_Building_RessourceProducer extends Rakuun_Intern_Production_Building {
	const WORKERS_PER_LEVEL = 50;
	
	private $baseIronProduction = 0;
	private $baseBerylliumProduction = 0;
	private $baseEnergyProduction = 0;
	private $basePeopleProduction = 0;
	
	public function __construct($dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_DESTRUCTIBLE_UNTIL_AVERAGE_IN_WAR, true);
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	public function getProducedIron($lastProductionTime = null, $workers = null, $level = null) {
		if ($lastProductionTime == null)
			$lastProductionTime = $this->getUser()->ressources->tick;
			
		if ($workers === null)
			$workers = $this->getWorkers();
			
		if ($level === null)
			$level = $this->getLevel();
		
		$workersLevel = $workers / self::WORKERS_PER_LEVEL;
		$level = ($workersLevel > $level) ? $level : $workersLevel;
		$production = ($level / 4 + $level / 5) * 6;
		$production *= (time() - $lastProductionTime) / 60;
		$production *= $this->getBaseIronProduction();
		$production *= Rakuun_Intern_Production_Influences::getRessourceProductionInfluenceRate(Rakuun_Intern_Production_Influences::RESSOURCE_IRON, $this->getUser());
		$production *= RAKUUN_RESSOURCEPRODUCTION_MULTIPLIER;
		
		return $production;
	}
	
	public function getProducedBeryllium($lastProductionTime = null, $workers = null, $level = null) {
		if ($lastProductionTime == null)
			$lastProductionTime = $this->getUser()->ressources->tick;
		
		if ($workers === null)
			$workers = $this->getWorkers();
			
		if ($level === null)
			$level = $this->getLevel();
		
		$workersLevel = $workers / self::WORKERS_PER_LEVEL;
		$level = ($workersLevel > $level) ? $level : $workersLevel;
		$production = ($level / 4 + $level / 5) * 6;
		$production *= (time() - $lastProductionTime) / 60;
		$production *= $this->getBaseBerylliumProduction();
		$production *= Rakuun_Intern_Production_Influences::getRessourceProductionInfluenceRate(Rakuun_Intern_Production_Influences::RESSOURCE_BERYLLIUM, $this->getUser());
		$production *= RAKUUN_RESSOURCEPRODUCTION_MULTIPLIER;
		
		return $production;
	}
	
	public function getProducedEnergy($lastProductionTime = null, $workers = null, $level = null) {
		if ($lastProductionTime == null)
			$lastProductionTime = $this->getUser()->ressources->tick;
		
		if ($workers === null)
			$workers = $this->getWorkers();
			
		if ($level === null)
			$level = $this->getLevel();
		
		$workersLevel = $workers / self::WORKERS_PER_LEVEL;
		$level = ($workersLevel > $level) ? $level : $workersLevel;
		$production = ($level / 4) * 6;
		$production *= (time() - $lastProductionTime) / 60;
		$production *= $this->getBaseEnergyProduction();
		$production *= Rakuun_Intern_Production_Influences::getRessourceProductionInfluenceRate(Rakuun_Intern_Production_Influences::RESSOURCE_ENERGY, $this->getUser());
		$production *= RAKUUN_RESSOURCEPRODUCTION_MULTIPLIER;
		
		return $production;
	}
	
	public function getProducedPeople($lastProductionTime = null, $workers = null, $level = null) {
		if ($lastProductionTime == null)
			$lastProductionTime = $this->getUser()->ressources->tick;
		
		if ($workers === null)
			$workers = $this->getWorkers();
			
		if ($level === null)
			$level = $this->getLevel();
		
		$workersLevel = $workers / self::WORKERS_PER_LEVEL;
		$level = ($workersLevel > $level) ? $level : $workersLevel;
		$production = (($level + 1) / 5) * 6;
		$production *= (time() - $lastProductionTime) / 60;
		$production *= $this->getBasePeopleProduction();
		$production *= Rakuun_Intern_Production_Influences::getRessourceProductionInfluenceRate(Rakuun_Intern_Production_Influences::RESSOURCE_PEOPLE, $this->getUser());
		$production *= RAKUUN_RESSOURCEPRODUCTION_MULTIPLIER;
		
		return $production;
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * Produced iron / minute
	 */
	public function getBaseIronProduction() {
		return $this->baseIronProduction;
	}
	
	/**
	 * Produced iron / minute
	 */
	public function setBaseIronProduction($baseIronProduction) {
		$this->baseIronProduction = $baseIronProduction;
	}
	
	/**
	 * Produced beryllium / minute
	 */
	public function getBaseBerylliumProduction() {
		return $this->baseBerylliumProduction;
	}
	
	/**
	 * Produced beryllium / minute
	 */
	public function setBaseBerylliumProduction($baseBerylliumProduction) {
		$this->baseBerylliumProduction = $baseBerylliumProduction;
	}
	
	/**
	 * Produced energy / minute
	 */
	public function getBaseEnergyProduction() {
		return $this->baseEnergyProduction;
	}
	
	/**
	 * Produced energy / minute
	 */
	public function setBaseEnergyProduction($baseEnergyProduction) {
		$this->baseEnergyProduction = $baseEnergyProduction;
	}
	
	/**
	 * Produced people / minute
	 */
	public function getBasePeopleProduction() {
		return $this->basePeopleProduction;
	}
	
	/**
	 * Produced people / minute
	 */
	public function setBasePeopleProduction($basePeopleProduction) {
		$this->basePeopleProduction = $basePeopleProduction;
	}
	
	/**
	 * @return amount of workers currently in this building
	 */
	public function getWorkers() {
		$workers = Rakuun_DB_Containers::getBuildingsWorkersContainer()->selectByUserFirst($this->getUser());
		return $workers->{Text::underscoreToCamelCase($this->getInternalName())};
	}
	
	public function getRequiredWorkers($level = null) {
		if ($level === null)
			$level = $this->getLevel();
		
		return $level * self::WORKERS_PER_LEVEL;
	}
}

?>