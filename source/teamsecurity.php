<?php

/**
 * Handles privileges for team members
 */
class Rakuun_TeamSecurity extends Security {
	const GROUP_SBMODS = 1;
	const GROUP_SUPPORTERS = 2;
	const GROUP_MULTIHUNTERS = 3;
	const GROUP_ADMINS = 4;
	const GROUP_RAPOLEDITORS = 5;
	const GROUP_REPORTED_MESSAGES = 6;
	const GROUP_USERMANAGERS = 7;
	const GROUP_DEVELOPER = 8;
	
	const PRIVILEGE_BACKENDACCESS = 1;
	const PRIVILEGE_USERLOCK = 2;
	const PRIVILEGE_USERUNLOCK = 3;
	const PRIVILEGE_USEREDIT = 4;
	const PRIVILEGE_ADDVIPS = 5;
	const PRIVILEGE_CHANGETEAMPRIVILEGES = 6;
	const PRIVILEGE_GAMEUPDATE = 7;
	const PRIVILEGE_CAUTION = 8;
	const PRIVILEGE_USERDELETE = 9;
	const PRIVILEGE_CAUTIONRESET = 10;
	const PRIVILEGE_MAIL = 11;
	const PRIVILEGE_SUPPORT = 12;
	const PRIVILEGE_REPORTEDMESSAGES = 13;
	const PRIVILEGE_RAPOL = 14;
	const PRIVILEGE_MULTIHUNTING = 15;
	const PRIVILEGE_SBMODERATION = 16;
	
	protected function __construct() {
		// Singleton
	}
	
	public function getContainerUsers() {
		return Rakuun_DB_Containers::getUserContainer();
	}
	
	public function getContainerUsersTableName() {
		return 'users';
	}
	
	protected function getTablePrefix() {
		return 'teamsecurity';
	}
	
	public function onSetup() {
		parent::onSetup();
		
		$groupSBMods = new DB_Record();
		$groupSBMods->name = 'Shoutbox-Moderatoren';
		$groupSBMods->groupIdentifier = self::GROUP_SBMODS;
		$this->getContainerGroups()->save($groupSBMods);
		$this->setPrivilege(self::PRIVILEGE_BACKENDACCESS, $groupSBMods);
		$this->setPrivilege(self::PRIVILEGE_CAUTION, $groupSBMods);
		$this->setPrivilege(self::PRIVILEGE_SBMODERATION, $groupSBMods);
		
		$groupSupporters = new DB_Record();
		$groupSupporters->name = 'Supporter';
		$groupSupporters->groupIdentifier = self::GROUP_SUPPORTERS;
		$this->getContainerGroups()->save($groupSupporters);
		$this->setPrivilege(self::PRIVILEGE_BACKENDACCESS, $groupSupporters);
		$this->setPrivilege(self::PRIVILEGE_SUPPORT, $groupSupporters);
		
		$groupMultihunters = new DB_Record();
		$groupMultihunters->name = 'Multihunter';
		$groupMultihunters->groupIdentifier = self::GROUP_MULTIHUNTERS;
		$this->getContainerGroups()->save($groupMultihunters);
		$this->setPrivilege(self::PRIVILEGE_BACKENDACCESS, $groupMultihunters);
		$this->setPrivilege(self::PRIVILEGE_MULTIHUNTING, $groupMultihunters);
		
		$groupAdmins = new DB_Record();
		$groupAdmins->name = 'Administratoren';
		$groupAdmins->groupIdentifier = self::GROUP_ADMINS;
		$this->getContainerGroups()->save($groupAdmins);
		$this->setPrivilege(self::PRIVILEGE_BACKENDACCESS, $groupAdmins);
		$this->setPrivilege(self::PRIVILEGE_ADDVIPS, $groupAdmins);
		$this->setPrivilege(self::PRIVILEGE_CHANGETEAMPRIVILEGES, $groupAdmins);
		$this->setPrivilege(self::PRIVILEGE_MAIL, $groupAdmins);
		
		$groupRapoleditors = new DB_Record();
		$groupRapoleditors->name = 'Rapol Redakteure';
		$groupRapoleditors->groupIdentifier = self::GROUP_RAPOLEDITORS;
		$this->getContainerGroups()->save($groupRapoleditors);
		$this->setPrivilege(self::PRIVILEGE_BACKENDACCESS, $groupRapoleditors);
		$this->setPrivilege(self::PRIVILEGE_RAPOL, $groupRapoleditors);
		
		$groupReportedmessages = new DB_Record();
		$groupReportedmessages->name = 'bearbeitet gemeldete Nachrichten';
		$groupReportedmessages->groupIdentifier = self::GROUP_REPORTED_MESSAGES;
		$this->getContainerGroups()->save($groupReportedmessages);
		$this->setPrivilege(self::PRIVILEGE_BACKENDACCESS, $groupReportedmessages);
		$this->setPrivilege(self::PRIVILEGE_REPORTEDMESSAGES, $groupReportedmessages);
		
		$groupUsermanagers = new DB_Record();
		$groupUsermanagers->name = 'Usermanager';
		$groupUsermanagers->groupIdentifier = self::GROUP_USERMANAGERS;
		$this->getContainerGroups()->save($groupUsermanagers);
		$this->setPrivilege(self::PRIVILEGE_BACKENDACCESS, $groupUsermanagers);
		$this->setPrivilege(self::PRIVILEGE_USERLOCK, $groupUsermanagers);
		$this->setPrivilege(self::PRIVILEGE_USERUNLOCK, $groupUsermanagers);
		$this->setPrivilege(self::PRIVILEGE_USEREDIT, $groupUsermanagers);
		$this->setPrivilege(self::PRIVILEGE_CAUTION, $groupUsermanagers);
		$this->setPrivilege(self::PRIVILEGE_USERDELETE, $groupUsermanagers);
		$this->setPrivilege(self::PRIVILEGE_CAUTIONRESET, $groupUsermanagers);
		
		$groupDevelopers = new DB_Record();
		$groupDevelopers->name = 'Entwickler';
		$groupDevelopers->groupIdentifier = self::GROUP_DEVELOPER;
		$this->getContainerGroups()->save($groupDevelopers);
		$this->setPrivilege(self::PRIVILEGE_BACKENDACCESS, $groupDevelopers);
		$this->setPrivilege(self::PRIVILEGE_GAMEUPDATE, $groupDevelopers);
	}
	
	/**
	 * TODO remove with php 5.3 (if todos for Security::get() have been fixed)
	 * @return Rakuun_TeamSecurity
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