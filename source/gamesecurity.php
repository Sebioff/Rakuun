<?php

/**
 * Handles privileges for common users
 */
class Rakuun_GameSecurity extends Security {
	const GROUP_NEEDS_ACTIVATION = 1;
	const GROUP_DEMO = 2;
	const GROUP_LOCKED = 3;
	const GROUP_TEAM = 4;
	const GROUP_DONORS = 5;
	const GROUP_SPONSORS = 6;
	const GROUP_BUGREPORTERS = 7;
	
	const PRIVILEGE_LOGIN = 1;
	const PRIVILEGE_COLOREDNAME = 2;
	const PRIVILEGE_DELETEACCOUNT = 3;
	
	private $vipGroups = array(self::GROUP_TEAM, self::GROUP_DONORS, self::GROUP_SPONSORS, self::GROUP_BUGREPORTERS);
	
	protected function __construct() {
		// Singleton
	}
	
	public function getVIPGroups() {
		$options = array();
		$options['conditions'][] = array('group_identifier IN (\''.implode('\', \'', $this->vipGroups).'\')');
		return $this->getContainerGroups()->select($options);
	}
	
	protected function getDefaultValue($prilegeIdentifier, DB_Record $user) {
		// if no value has been set, every privilege is granted by default (except colored names)
		if ($prilegeIdentifier == self::PRIVILEGE_COLOREDNAME)
			return parent::getDefaultValue($prilegeIdentifier, $user);
		else
			return true;
	}
	
	public function getContainerUsers() {
		return Rakuun_DB_Containers::getUserContainer();
	}
	
	public function getContainerUsersTableName() {
		return 'users';
	}
	
	protected function getTablePrefix() {
		return 'gamesecurity';
	}
	
	public function onSetup() {
		parent::onSetup();
		
		$groupNeedsActivation = new DB_Record();
		$groupNeedsActivation->name = 'Nicht aktivierte Spieler';
		$groupNeedsActivation->groupIdentifier = self::GROUP_NEEDS_ACTIVATION;
		$this->getContainerGroups()->save($groupNeedsActivation);
		$this->setPrivilege(self::PRIVILEGE_LOGIN, $groupNeedsActivation, false);
		
		$groupLocked = new DB_Record();
		$groupLocked->name = 'Gesperrte Spieler';
		$groupLocked->groupIdentifier = self::GROUP_LOCKED;
		$this->getContainerGroups()->save($groupLocked);
		$this->setPrivilege(self::PRIVILEGE_LOGIN, $groupLocked, false);
		
		$groupTeam = new DB_Record();
		$groupTeam->name = 'Teammitglieder';
		$groupTeam->groupIdentifier = self::GROUP_TEAM;
		$this->getContainerGroups()->save($groupTeam);
		$this->setPrivilege(self::PRIVILEGE_COLOREDNAME, $groupTeam);
		
		$groupDonors = new DB_Record();
		$groupDonors->name = 'Spender';
		$groupDonors->groupIdentifier = self::GROUP_DONORS;
		$this->getContainerGroups()->save($groupDonors);
		$this->setPrivilege(self::PRIVILEGE_COLOREDNAME, $groupDonors);
		
		$groupSponsors = new DB_Record();
		$groupSponsors->name = 'Sponsoren';
		$groupSponsors->groupIdentifier = self::GROUP_SPONSORS;
		$this->getContainerGroups()->save($groupSponsors);
		$this->setPrivilege(self::PRIVILEGE_COLOREDNAME, $groupSponsors);
		
		$groupBugreporters = new DB_Record();
		$groupBugreporters->name = 'Bugmelder';
		$groupBugreporters->groupIdentifier = self::GROUP_BUGREPORTERS;
		$this->getContainerGroups()->save($groupBugreporters);
		$this->setPrivilege(self::PRIVILEGE_COLOREDNAME, $groupBugreporters);
	}
	
	/**
	 * TODO remove with php 5.3 (if todos for Security::get() have been fixed)
	 * @return Rakuun_GameSecurity
	 */
	public static function get($class = '', $name = '') {
		return parent::get(__CLASS__, $name);
	}
	
	// TODO remove with php 5.3 (if todos for Security::push() have been fixed)
	public static function push(Security $context, $name = '', $class = '') {
		parent::push($context, $name, __CLASS__);
	}
	
	// TODO remove with php 5.3 (if todos for Security::pop() have been fixed)
	public static function pop($name = '', $class = '') {
		parent::pop($name, __CLASS__);
	}
}

?>