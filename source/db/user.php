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
 * @property Rakuun_DB_Ressources $ressources
 * @property Rakuun_DB_Buildings $buildings
 * @property Rakuun_DB_Technologies $technologies
 * @property Rakuun_DB_Alliance $alliance
 */
class Rakuun_DB_User extends DB_Record implements Rakuun_Intern_Production_Owner {
	const DELETED_USER_NAME = 'gelöschter User';
	
	public function __construct() {
		$this->setVirtualProperty('ressources', array($this, 'getRessources'));
		$this->setVirtualProperty('buildings', array($this, 'getBuildings'));
		$this->setVirtualProperty('technologies', array($this, 'getTechnologies'));
		$this->setVirtualProperty('units', array($this, 'getUnits'));
		$this->setVirtualProperty('armies', array($this, 'getArmies'));
		$this->setVirtualProperty('name_uncolored', array($this, 'getNameUncolored'));
		$this->setVirtualProperty('att', array($this, 'getAttackValue'));
		$this->setVirtualProperty('deff', array($this, 'getDefenseValue'));
		//check for user callbacks
		Rakuun_User_Callbacks::get($this)->run();
	}
	
	public function getRessources() {
		$container = Rakuun_DB_Containers::getRessourcesContainer();
		return $container->selectByUserFirst($this);
	}
	
	protected function getBuildings() {
		$container = Rakuun_DB_Containers::getBuildingsContainer();
		return $container->selectByUserFirst($this);
	}
	
	protected function getTechnologies() {
		$container = Rakuun_DB_Containers::getTechnologiesContainer();
		return $container->selectByUserFirst($this);
	}
	
	protected function getUnits() {
		$container = Rakuun_DB_Containers::getUnitsContainer();
		return $container->selectByUserFirst($this);
	}
	
	protected function getArmies() {
		$container = Rakuun_DB_Containers::getArmiesContainer();
		return $container->selectByUser($this);
	}
	
	protected function getNameUncolored() {
		return parent::__get('name');
	}
	
	/**
	 * Checks if a name containing color codes actually is a valid name for this
	 * user.
	 */
	public function validName($nameColored) {
		$patterns = array(
			'%\[darkblue\](.*?)\[/darkblue\]%',
			'%\[lime\](.*?)\[/lime\]%',
			'%\[limeblue\](.*?)\[/limeblue\]%',
			'%\[purple\](.*?)\[/purple\]%',
			'%\[pink\](.*?)\[/pink\]%',
			'%\[brown\](.*?)\[/brown\]%',
			'%\[gold\](.*?)\[/gold\]%',
			'%\[orange\](.*?)\[/orange\]%',
			'%\[lightgrey\](.*?)\[/lightgrey\]%',
			'%\[darkgrey\](.*?)\[/darkgrey\]%',
			'%\[white\](.*?)\[/white\]%',
			'%\[\#([\da-fA-F]{6})\](.*?)\[/#\1\]%'
		);
		
		$replacements = array(
			'$1',
			'$1',
			'$1',
			'$1',
			'$1',
			'$1',
			'$1',
			'$1',
			'$1',
			'$1',
			'$1',
			'$2'
		);
		
		$nameColored = preg_replace($patterns, $replacements, $nameColored);
		if ($nameColored == parent::__get('name'))
			return true;
		else
			return false;
	}

	public function recalculatePoints() {
		$points = 0;

		foreach (Rakuun_Intern_Production_Factory::getAllBuildings($this) as $building) {
			$points += $building->getPoints() * $building->getLevel();
		}

		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies($this) as $technology) {
			$points += $technology->getPoints() * $technology->getLevel();
		}

		$this->points = $points;
		$this->save();

		if ($this->alliance)
			$this->alliance->recalculatePoints();

		$this->reachNoob();
	}
	
	/**
	 * @return true if the user is logged in, false otherwhise.
	 * A user is considered being logged in if his last activity has been less
	 * than Rakuun_Intern_Module::TIMEOUT_ISONLINE seconds ago.
	 */
	public function isOnline() {
		return ($this->isOnline > time() - Rakuun_Intern_Module::TIMEOUT_ISONLINE);
	}
	
	/**
	 * @return true, if user is in noob, false otherwise.
	 */
	public function isInNoob() {
		return $this->isInNoob;
	}
	
	/**
	 * @return true, if user is an yimtay, false otherwise.
	 */
	public function isYimtay() {
		return (bool)$this->isYimtay;
	}
	
	public function isLocked() {
		return Rakuun_GameSecurity::get()->isInGroup($this, Rakuun_GameSecurity::GROUP_LOCKED);
	}
	
	public function isDemo() {
		return Rakuun_GameSecurity::get()->isInGroup($this, Rakuun_GameSecurity::GROUP_DEMO);
	}
	
	/**
	 * @return number of Databases the user have
	 */
	public function getDatabaseCount() {
		$options = array();
		$options['conditions'][] = array('identifier IN ('.implode(', ', Rakuun_User_Specials_Database::getDatabaseIdentifiers()).')');
		$options['conditions'][] = array('user = ?', $this);
		return Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->count($options);
	}
	
	/**
	 * checks, if the user reached the noob or not.
	 * A User reched the noob, if he
	 * 1. has less points then the average (or the startlimit)
	 * 2. has less armystrength then the average (or the startlimit)
	 * 3. has no DB
	 * 4. has no armys in movement
	 * 5. has no shield generator
	 *
	 * TODO this method is called very often and contains some huge calculations
	 * -> cache results of user count / points sum etc.
	 */
	public function reachNoob() {
		$oldNoobState = $this->isInNoob();
		$this->isInNoob = (!$this->isYimtay()
						&& $this->isBelowNoobPointLimit()
						&& $this->isBelowNoobArmyLimit()
						&& $this->buildings->shieldGenerator == 0	// no shield generator
						&& $this->getDatabaseCount() == 0	// no databases
						&& !Rakuun_DB_Containers::getArmiesContainer()->selectByUserFirst($this));	// no armies
						
						
		if ($oldNoobState != $this->isInNoob) {
			$this->save();
			
			// cancel all incomming attacks when falling back to noob
			if ($this->isInNoob) {
				$attackers = array();
				$options = array();
				$options['conditions'][] = array('target = ?', $this);
				$options['conditions'][] = array('target_x = ?', $this->cityX);
				$options['conditions'][] = array('target_y = ?', $this->cityY);
				$options['conditions'][] = array('spydrone = 0');
				$options['conditions'][] = array('cloaked_spydrone = 0');
				foreach (Rakuun_DB_Containers::getArmiesContainer()->select($options) as $army) {
					$attackers[] = $army->user;
					Rakuun_DB_Containers::getArmiesPathsContainer()->deleteByArmy($army);
					$army->targetX = $army->user->cityX;
					$army->targetY = $army->user->cityY;
					$army->tick = time();
					$army->targetTime = 0;
					$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($army);
					$pathCalculator->getPath();
					$army->save();
				}
				
				foreach ($attackers as $attacker) {
					$text = 'Die Stadt '.$this->cityName.' von '.$this->name.' ist nicht mehr angreifbar. Sämtliche unserer Armeen sind auf dem Rückweg.';
					$igm = new Rakuun_Intern_IGM('Ziel nicht angreifbar', $attacker, $text, Rakuun_Intern_IGM::TYPE_FIGHT);
					$igm->setSenderName(Rakuun_Intern_IGM::SENDER_FIGHTS);
					$igm->send();
				}
			}
		}
	}
	
	private function isBelowNoobPointLimit() {
		return ($this->points <= Rakuun_Intern_Statistics::getNoobPointLimit());	// points below point limit;
	}
	
	private function isBelowNoobArmyLimit() {
		return ($this->getArmyStrength() <= Rakuun_Intern_Statistics::getNoobArmyStrengthLimit()); //armystrength below armystrength limit
	}
	
	/**
	 * Checks if the given user can destroy buildings of this user
	 * @param[in] Rakuun_DB_User user who wants to attack
	 * @return boolean true, if the given user can destroy buildings of this user,
	 * false otherwise
	 */
	public function canBeBashed(Rakuun_DB_User $user) {
		return (($user->points * RAKUUN_NOOB_SECURE_PERCENTAGE <= $this->points
			&& $user->points / RAKUUN_NOOB_SECURE_PERCENTAGE >= $this->points)
			|| $this->getDatabaseCount() > 0
			|| $this->buildings->shieldGenerator > 0
			|| $this->isYimtay());
	}
	
	public function produceRessources() {
		DB_Connection::get()->beginTransaction();
		$options = array();
		$options['lock'] = DB_Container::LOCK_FOR_UPDATE;
		$ressources = Rakuun_DB_Containers::getRessourcesContainer()->selectByUserFirst($this, $options);
		$producedIron = $ressources->producedIron + Rakuun_Intern_Production_Factory::getBuilding('ironmine', $this)->getProducedIron();
		$producedBeryllium = $ressources->producedBeryllium + Rakuun_Intern_Production_Factory::getBuilding('berylliummine', $this)->getProducedBeryllium();
		$producedEnergy = $ressources->producedEnergy + Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant', $this)->getProducedEnergy();
		$producedPeople = $ressources->producedPeople + Rakuun_Intern_Production_Factory::getBuilding('clonomat', $this)->getProducedPeople();
		if ($producedIron >= 1 || $producedBeryllium >= 1 || $producedEnergy >= 1 || $producedPeople >= 1) {
		 	$finishedIron = floor($producedIron);
		 	$unfinishedIron = $producedIron - $finishedIron;
		 	$finishedBeryllium = floor($producedBeryllium);
		 	$unfinishedBeryllium = $producedBeryllium - $finishedBeryllium;
		 	$finishedEnergy = floor($producedEnergy);
		 	$unfinishedEnergy = $producedEnergy - $finishedEnergy;
		 	$finishedPeople = floor($producedPeople);
		 	$unfinishedPeople = $producedPeople - $finishedPeople;
		 	$ressources->raise($finishedIron, $finishedBeryllium, $finishedEnergy, $finishedPeople);
		 	$ressources->producedIron = $unfinishedIron;
		 	$ressources->producedBeryllium = $unfinishedBeryllium;
		 	$ressources->producedEnergy = $unfinishedEnergy;
		 	$ressources->producedPeople = $unfinishedPeople;
		 	$ressources->tick = time();
		 	$ressources->save();
		}
	 	DB_Connection::get()->commit();
	}
	
	public function getAttackValue() {
		$att = 0;
		$units = Rakuun_Intern_Production_Factory::getAllUnits($this);
		foreach ($units as $unit) {
			$att += $unit->getAttackValue($unit->getAmount() + $unit->getAmountNotAtHome());
		}
		return $att;
	}
	
	public function getDefenseValue() {
		$deff = 0;
		$units = Rakuun_Intern_Production_Factory::getAllUnits($this);
		foreach ($units as $unit) {
			$deff += $unit->getDefenseValue($unit->getAmount() + $unit->getAmountNotAtHome());
		}
		return $deff;
	}
	
	public function getArmyStrength($includingUnitsInProduction = false) {
		$sum = 0;
		$units = Rakuun_Intern_Production_Factory::getAllUnits($this);
		foreach ($units as $unit) {
			$sum += $unit->getArmyStrength($unit->getAmount() + $unit->getAmountNotAtHome());
		}
		if ($includingUnitsInProduction) {
			$options = array();
			$options['properties'] = 'unit, SUM(amount) AS amount';
			$options['conditions'][] = array('user = ?', $this);
			$options['group'] = 'unit';
			foreach (Rakuun_DB_Containers::getUnitsWIPContainer()->select($options) as $unitInProduction) {
				$sum += Rakuun_Intern_Production_Factory::getUnit($unitInProduction->unit)->getArmyStrength($unitInProduction->amount);
			}
		}
		return $sum;
	}
	
	public function addXP($amount) {
		$this->xp = $this->xp + $amount;
		$this->save();
	}
	
	/**
	 * @return reached level of a user. level is equivalent to no of skillpoints
	 */
	public function getLevel() {
		return ($this->xp / 100);
	}
	
	/**
	 * @see db/DB_Record#__get()
	 */
	public function __get($property) {
		$value = parent::__get($property);
		
		if ($property == 'name') {
			if ($nameColored = parent::__get('nameColored')) {
				$value = Rakuun_Text::colorUsername($nameColored);
			}
		}
		
		return $value;
	}
}

?>