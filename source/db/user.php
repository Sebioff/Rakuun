<?php

class Rakuun_DB_User extends DB_Record implements Rakuun_Intern_Production_Owner {
	const DELETED_USER_NAME = 'gelöschter User';
	
	public function __construct() {
		$this->setVirtualProperty('ressources', array($this, 'getRessources'));
		$this->setVirtualProperty('buildings', array($this, 'getBuildings'));
		$this->setVirtualProperty('technologies', array($this, 'getTechnologies'));
		$this->setVirtualProperty('units', array($this, 'getUnits'));
		$this->setVirtualProperty('armies', array($this, 'getArmies'));
		$this->setVirtualProperty('name_uncolored', array($this, 'getNameUncolored'));
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
	 * Translates a name containing color codes into an actually colored name.
	 */
	protected function colorName($nameColored) {
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
			'%\[(\#[\da-fA-F]{6})\](.*?)\[/\1\]%'
		);
		
		$replacements = array(
			'<span style="color:#000080">$1</span>',
			'<span style="color:#00FF00">$1</span>',
			'<span style="color:#00FFFF">$1</span>',
			'<span style="color:#800080">$1</span>',
			'<span style="color:#FF00FF">$1</span>',
			'<span style="color:#800000">$1</span>',
			'<span style="color:#808000">$1</span>',
			'<span style="color:#FF7F00">$1</span>',
			'<span style="color:#C0C0C0">$1</span>',
			'<span style="color:#808080">$1</span>',
			'<span style="color:#FFFFFF">$1</span>',
			'<span style="color:$1">$2</span>'
		);
		
		return preg_replace($patterns, $replacements, $nameColored);
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
			'%\[\#[\da-fA-F]{6}\](.*?)\[/#[\da-fA-F]{6}\]%'
		);
		
		$nameColored = preg_replace($patterns, '$1', $nameColored);
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
	 * than Rakuun_Intern_Module::TIMEOUT_NOACTIVITY seconds ago.
	 */
	public function isOnline() {
		return ($this->isOnline > time() - Rakuun_Intern_Module::TIMEOUT_NOACTIVITY);
	}
	
	/**
	 * @return true, if user is in noob, false otherwise.
	 */
	public function isInNoob() {
		return $this->isInNoob;
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
	private function reachNoob() {
		// calc average points
		$average = Rakuun_Intern_Statistics::averagePoints();
		$nooblimit = $average;
		if ($average < RAKUUN_NOOB_START_LIMIT_OF_POINTS)
			$nooblimit = RAKUUN_NOOB_START_LIMIT_OF_POINTS;
		
		// calc armystrength
		$average = Rakuun_Intern_Statistics::averageArmyStrength();
		$armyStrengthLimit = $average;
		if ($armyStrengthLimit < RAKUUN_NOOB_START_LIMIT_OF_ARMY_STRENGTH)
			$armyStrengthLimit = RAKUUN_NOOB_START_LIMIT_OF_ARMY_STRENGTH;
		$units = Rakuun_Intern_Production_Factory::getAllUnits($this);
		$armyStrength = 0;
		foreach ($units as $unit) {
			$armyStrength += $unit->getArmyStrength();
		}

		$this->isInNoob = ($this->points <= $nooblimit	// points below point limit
						&& $armyStrength <= $armyStrengthLimit //armystrength below armystrength limit
						&& $this->buildings->shieldGenerator == 0	// no shield generator
						&& $this->getDatabaseCount() == 0	// no databases
						&& !Rakuun_DB_Containers::getArmiesContainer()->selectByUserFirst($this));	// no armies
		$this->save();
	}
	
	/**
	 * checks if the targetuser can be attacked by the attacker.
	 * @param[in] user User who wants to attack
	 * @return true, if user can be attacked by the other user, false otherwise
	 */
	public function canBeAttacked(Rakuun_DB_User $user) {
		return (($user->points * RAKUUN_NOOB_SECURE_PERCENTAGE <= $this->points
			&& $user->points / RAKUUN_NOOB_SECURE_PERCENTAGE >= $this->points)
			|| $this->getDatabaseCount() > 0
			|| $this->buildings->shieldGenerator > 0);
	}
	
	public function produceRessources() {
		DB_Connection::get()->beginTransaction();
		$ressources = $this->ressources;
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
	
	/**
	 * @see db/DB_Record#__get()
	 */
	public function __get($property) {
		$value = parent::__get($property);
		
		if ($property == 'name') {
			if ($nameColored = parent::__get('nameColored')) {
				$value = $this->colorName($nameColored);
			}
		}
		
		return $value;
	}
}

?>