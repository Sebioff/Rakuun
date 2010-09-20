<?php

/**
 * Handles privileges for everything related to alliances
 */
class Rakuun_Intern_Alliance_Security extends Security {
	private $alliance = null;
	private $containerUsers = null;
	private $containerGroups = null;
	
	const GROUP_LEADERS = 1;
	
	const PRIVILEGE_VOTINGS = 1;
	const PRIVILEGE_INFORMATION = 2;
	const PRIVILEGE_APPLICATIONS = 3;
	const PRIVILEGE_MESSAGES = 4;
	const PRIVILEGE_RANKS = 5;
	const PRIVILEGE_KICKING = 6;
	const PRIVILEGE_RESSOURCES = 7;
	const PRIVILEGE_NEWSLETTER = 8;
	const PRIVILEGE_DIPLOMACY = 9;
	const PRIVILEGE_SEE_STATISTICS = 10;
	const PRIVILEGE_SEE_ACTIVITY = 11;
	const PRIVILEGE_MODERATION = 13;
	const PRIVILEGE_SEE_REPORTS = 14;
	
	// not public changeable privileges
	const PRIVILEGE_APPLYFORMETA = 12;
	
	protected function __construct(DB_Record $alliance = null) {
		if (!$alliance)
			// FIXME remove next if() as soon as modules get instantiated in
			// a better way (currently it'll crash if not logged in without the if())
			if (isset(Rakuun_User_Manager::getCurrentUser()->alliance))
				$alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		
		$this->alliance = $alliance;
		$this->definePrivilege(self::PRIVILEGE_VOTINGS, 'Votings erstellen', 'Darf allianzinterne Votings erstellen');
		$this->definePrivilege(self::PRIVILEGE_INFORMATION, 'Allianz-Info ändern', 'Darf die Beschreibungstexte der Allianz ändern');
		$this->definePrivilege(self::PRIVILEGE_APPLICATIONS, 'Bewerbungen annehmen/ablehnen', 'Darf Bewerbungen bei der Allianz annehmen und ablehnen');
		$this->definePrivilege(self::PRIVILEGE_MESSAGES, 'Allianznachrichten editieren/löschen', 'Darf Nachrichten im Allianzforum bearbeiten und löschen');
		$this->definePrivilege(self::PRIVILEGE_RANKS, 'Ränge bearbeiten/erstellen', 'Darf Allianzränge bearbeiten und erstellen und diese Allianzmitgliedern zuweisen');
		$this->definePrivilege(self::PRIVILEGE_KICKING, 'User kicken', 'Darf Mitglieder aus der Allianz entfernen');
		$this->definePrivilege(self::PRIVILEGE_RESSOURCES, 'Rohstoffe übertragen', 'Darf Rohstoffe aus der Allianzkasse an Allianzmitglieder übertragen');
		$this->definePrivilege(self::PRIVILEGE_NEWSLETTER, 'Allianz-Rundmail schreiben', 'Darf Rundmails schreiben die an sämtliche Allianzmitglieder versendet werden');
		$this->definePrivilege(self::PRIVILEGE_DIPLOMACY, 'Diplomatische Aktionen durchführen', 'Darf Bündnisse und Kriege mit anderen Allianzen vorschlagen und annehmen');
		$this->definePrivilege(self::PRIVILEGE_SEE_STATISTICS, 'Statistiken einsehen', 'Darf Statistiken über die Armee und Rohstoffe der Allianzmitglieder einsehen');
		$this->definePrivilege(self::PRIVILEGE_SEE_ACTIVITY, 'Aktivität einsehen', 'Darf sehen, wann Allianzmitglieder zum letzten Mal aktiv waren');
		$this->definePrivilege(self::PRIVILEGE_MODERATION, 'Moderator', 'Darf Shoutbox, Foren und Umfragen bearbeiten');
		$this->definePrivilege(self::PRIVILEGE_SEE_REPORTS, 'Spionageberichte einsehen', 'Darf die Spionageberichte der ganzen Allianz einsehen');
	}
	
	/**
	 * @return DB_Container
	 */
	public function getContainerUsers() {
		if ($this->containerUsers == null) {
			$this->containerUsers = Rakuun_DB_Containers::getUserContainer();
			
			if ($this->alliance) {
				$filter = array();
				$filter['conditions'][] = array($this->containerUsers->getTable().'.alliance = ?', $this->alliance);
				$this->containerUsers = $this->containerUsers->getFilteredContainer($filter);
			}
		}
		
		return $this->containerUsers;
	}
	
	/**
	 * @return DB_Container
	 */
	public function getContainerGroups() {
		if ($this->containerGroups == null) {
			$this->containerGroups = parent::getContainerGroups();
			
			if ($this->alliance) {
				$filter = array();
				$filter['conditions'][] = array($this->containerGroups->getTable().'.alliance = ?', $this->alliance);
				$this->containerGroups = $this->containerGroups->getFilteredContainer($filter);
			}
		}
		
		return $this->containerGroups;
	}
	
	protected function getDefaultValue($privilegeIdentifier, DB_Record $user) {
		if ($this->isInGroup($user, self::GROUP_LEADERS))
			return true;
		else
			return parent::getDefaultValue($privilegeIdentifier, $user);
	}
	
	protected function getTablePrefix() {
		return 'alliances';
	}
	
	public function getContainerUsersTableName() {
		return 'users';
	}
	
	public function onSetup() {
		parent::onSetup();
		
		Core_MigrationsLoader::executeMigration(dirname(__FILE__).'/migrations/001.additional_columns.php', array('self' => $this));
	}
	
	/**
	 * TODO remove with php 5.3 (if todos for Security::get() have been fixed)
	 * @return Rakuun_Intern_Alliance_Security
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
	
	public static function getForAlliance(DB_Record $alliance) {
		return new self($alliance);
	}
	
	public static function getForAllianceById($id) {
		return new self(Rakuun_DB_Containers::getAlliancesContainer()->selectByIdFirst($id));
	}
}

?>