<?php

class Rakuun_DB_Meta extends DB_Record implements Rakuun_Intern_Production_Owner {
	public function __construct() {
		$this->setVirtualProperty('members', array($this, 'getMembers'));
		$this->setVirtualProperty('alliances', array($this, 'getAlliances'));
		$this->setVirtualProperty('buildings', array($this, 'getBuildings'));
		$this->setVirtualProperty('ressources', array($this, 'getRessources'));
	}
	
	/**
	 * get all alliances of the meta
	 * @return filtered Rakuun_DB_Alliance
	 */
	protected function getAlliances() {
		$filter['conditions'][] = array('meta = ?', $this);
		return Rakuun_DB_Containers::getAlliancesContainer()->getFilteredContainer($filter);
	}
	
	public function getRessources() {
		return $this;
	}
	
	protected function getBuildings() {
		$container = Rakuun_DB_Containers::getMetasBuildingsContainer();
		return $container->selectByMetaFirst($this);
	}
	
	/**
	 * get all users of the meta
	 * @return array of Rakuun_DB_User
	 */
	protected function getMembers() {
		$alliances = Rakuun_DB_Containers::getAlliancesContainer()->getTable();
		$metas = Rakuun_DB_Containers::getMetasContainer()->getTable();
		$users = Rakuun_DB_Containers::getUserContainer()->getTable();
		$options = array();
		$options['join'] = array($alliances, $metas);
		$options['conditions'][] = array($users.'.alliance = '.$alliances.'.id');
		$options['conditions'][] = array($alliances.'.meta = '.$metas.'.id');
		$options['conditions'][] = array($metas.'.id = ?', $this->getPK());
		return Rakuun_DB_Containers::getUserContainer()->select($options);
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
	
	public function getShieldGeneratorCount() {
		$options = array();
		$shieldGenerator = new Rakuun_Intern_Production_Building_ShieldGenerator();
		$buildingsTable = Rakuun_DB_Containers::getBuildingsContainer()->getTable();
		$userTable = Rakuun_DB_Containers::getUserContainer()->getTable();
		$alliancesTable = Rakuun_DB_Containers::getAlliancesContainer()->getTable();
		$metasTable = Rakuun_DB_Containers::getMetasContainer()->getTable();
		$options['join'] = array($userTable, $alliancesTable, $metasTable);
		$options['conditions'][] = array($buildingsTable.'.'.$shieldGenerator->getInternalName().' >= ?', 1);
		$options['conditions'][] = array($buildingsTable.'.user = '.$userTable.'.id');
		$options['conditions'][] = array($userTable.'.alliance = '.$alliancesTable.'.id');
		$options['conditions'][] = array($alliancesTable.'.meta = '.$metasTable.'.id');
		$options['conditions'][] = array($metasTable.'.id = ?', $this->getPK());
		return Rakuun_DB_Containers::getBuildingsContainer()->count($options);
	}
	
	/**
	 * @return array of Rakuun_DB_User, sorted by defense sequence
	 */
	public function getCurrentShieldGeneratorOwners() {
		$options = array();
		$shieldGenerator = new Rakuun_Intern_Production_Building_ShieldGenerator();
		$buildingsTable = Rakuun_DB_Containers::getBuildingsContainer()->getTable();
		$userTable = Rakuun_DB_Containers::getUserContainer()->getTable();
		$alliancesTable = Rakuun_DB_Containers::getAlliancesContainer()->getTable();
		$metasTable = Rakuun_DB_Containers::getMetasContainer()->getTable();
		$options['join'] = array($buildingsTable, $alliancesTable, $metasTable);
		$options['order'] = $userTable.'.ID ASC';
		$options['conditions'][] = array($buildingsTable.'.'.$shieldGenerator->getInternalName().' >= ?', 1);
		$options['conditions'][] = array($buildingsTable.'.user = '.$userTable.'.id');
		$options['conditions'][] = array($userTable.'.alliance = '.$alliancesTable.'.id');
		$options['conditions'][] = array($alliancesTable.'.meta = '.$metasTable.'.id');
		$options['conditions'][] = array($metasTable.'.id = ?', $this->getPK());
		return Rakuun_DB_Containers::getUserContainer()->select($options);
	}
	
	/**
	 * @return Rakuun_DB_User
	 */
	public function getCurrentShieldGeneratorHolder() {
		$options = array();
		$shieldGenerator = new Rakuun_Intern_Production_Building_ShieldGenerator();
		$buildingsTable = Rakuun_DB_Containers::getBuildingsContainer()->getTable();
		$userTable = Rakuun_DB_Containers::getUserContainer()->getTable();
		$alliancesTable = Rakuun_DB_Containers::getAlliancesContainer()->getTable();
		$metasTable = Rakuun_DB_Containers::getMetasContainer()->getTable();
		$options['join'] = array($buildingsTable, $alliancesTable, $metasTable);
		$options['order'] = $userTable.'.ID ASC';
		$options['conditions'][] = array($buildingsTable.'.'.$shieldGenerator->getInternalName().' >= ?', 1);
		$options['conditions'][] = array($buildingsTable.'.user = '.$userTable.'.id');
		$options['conditions'][] = array($userTable.'.alliance = '.$alliancesTable.'.id');
		$options['conditions'][] = array($alliancesTable.'.meta = '.$metasTable.'.id');
		$options['conditions'][] = array($metasTable.'.id = ?', $this->getPK());
		return Rakuun_DB_Containers::getUserContainer()->selectFirst($options);
	}
	
	public function hasMemberWithShieldGenerator() {
		return ($this->getShieldGeneratorCount() > 0);
	}
}

?>