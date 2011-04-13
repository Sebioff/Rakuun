<?php

/**
 * @property Rakuun_DB_Meta $meta
 */
class Rakuun_DB_Alliance extends DB_Record implements Rakuun_Intern_Production_Owner {
	public function __construct() {
		$this->setVirtualProperty('members', array($this, 'getMembers'));
		$this->setVirtualProperty('buildings', array($this, 'getBuildings'));
		$this->setVirtualProperty('ressources', array($this, 'getRessources'));
	}
	
	public function getRessources() {
		return $this;
	}
	
	protected function getMembers() {
		return Rakuun_DB_Containers::getUserContainer()->select(array('conditions' => array(array('alliance = ?', $this)), 'order' => 'name ASC'));
	}
	
	protected function getBuildings() {
		$container = Rakuun_DB_Containers::getAlliancesBuildingsContainer();
		return $container->selectByAllianceFirst($this);
	}
	
	/**
	 * Check diplomacy between this and another alliance.
	 * @param $other Alliance
	 * @return DB_Record
	 */
	public function getDiplomacy(Rakuun_DB_Alliance $other) {
		$options['conditions'][] = array('status != ?', Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::STATUS_NEW);
		$options['conditions'][] = array('(alliance_active = ? AND alliance_passive = ?) OR (alliance_active = ? AND alliance_passive = ?)', $other, $this, $this, $other);
		return Rakuun_DB_Containers::getAlliancesDiplomaciesContainer()->selectFirst($options);
	}
	
	public function lower($iron, $beryllium = 0, $energy = 0, $people = 0) {
		if ($this->iron - $iron < 0)
			$iron = $this->iron;
		if ($this->beryllium - $beryllium < 0)
			$beryllium = $this->beryllium;
		if ($this->energy - $energy < 0)
			$energy = $this->energy;
		if ($this->people - $people < 0)
			$people = $this->people;
		$databaseSchema = $this->getContainer()->getDatabaseSchema();
		$query = 'UPDATE '.$this->getContainer()->getTable().' SET
			iron = iron - '.$iron.', beryllium = beryllium - '.$beryllium.', energy = energy - '.$energy.', people = people - '.$people.'
			WHERE '.$databaseSchema['primaryKey'].' = '.$this->getPK();
		if (DB_Connection::get()->query($query) === true) {
			$this->iron -= $iron;
			$this->beryllium -= $beryllium;
			$this->energy -= $energy;
			$this->people -= $people;
		}
	}
	
	public function raise($iron, $beryllium = 0, $energy = 0, $people = 0) {
		$databaseSchema = $this->getContainer()->getDatabaseSchema();
		$query = 'UPDATE '.$this->getContainer()->getTable().' SET
			iron = iron + '.$iron.', beryllium = beryllium + '.$beryllium.', energy = energy + '.$energy.', people = people + '.$people.'
			WHERE '.$databaseSchema['primaryKey'].' = '.$this->getPK();
		if (DB_Connection::get()->query($query) === true) {
			$this->iron += $iron;
			$this->beryllium += $beryllium;
			$this->energy += $energy;
			$this->people += $people;
		}
	}
	
	public function recalculatePoints() {
		$this->points = 0;
		$options = array();
		$options['properties'] = 'points';
		foreach (Rakuun_DB_Containers::getUserContainer()->selectByAlliance($this, $options) as $member) {
			$this->points += $member->points;
		}
		$this->save();
	}
	
	public function getAverageMilitaryStrength($includingUnitsInProduction = false) {
		$sum = 0;
		$count = 0;
		foreach ($this->getMembers() as $member) {
			$sum += $member->getArmyStrength($includingUnitsInProduction);
			$count++;
		}
		return $sum / $count;
	}
	
	public function canSeeDatabase($identifier) {
		return in_array($identifier, Rakuun_User_Specials_Database::getVisibleDatabasesForAlliance($this));
	}
}

?>