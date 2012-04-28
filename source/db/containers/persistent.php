<?php

abstract class Rakuun_DB_Containers_Persistent {
	private static $userContainer = null;
	private static $userDeletedContainer = null;
	private static $alliancesContainer = null;
	private static $metasContainer = null;
	private static $buildingsContainer = null;
	private static $technologiesContainer = null;
	private static $unitsContainer = null;
	private static $logUnitsProductionContainer = null;
	private static $logFightsContainer = null;
	private static $logUserRessourcetransferContainer = null;
	private static $roundInformationContainer = null;
	private static $newsContainer = null;
	private static $boardsGlobalContainer = null;
	private static $boardsGlobalPostingsContainer = null;
	private static $boardsGlobalLastVisitedContainer = null;
	private static $eternalUserContainer = null;
	private static $eternalUserUserAssocContainer = null;
	private static $eternalUserAchievementContainer = null;
	
	private static $persistentConnection = null;
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Container
	 */
	public static function getUserContainer() {
		if (self::$userContainer)
			return self::$userContainer;
		
		self::$userContainer = new DB_Container('user', 'Rakuun_DB_User');
		self::$userContainer->setConnection(self::getPersistentConnection());
		self::$userContainer->addReferencedContainer(self::getAlliancesContainer(), 'alliance', 'id');
		
		return self::$userContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getUserDeletedContainer() {
		if (self::$userDeletedContainer)
			return self::$userDeletedContainer;
		
		self::$userDeletedContainer = new DB_Container('users_deleted', 'Rakuun_DB_User');
		self::$userDeletedContainer->setConnection(self::getPersistentConnection());
		
		return self::$userDeletedContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getAlliancesContainer() {
		if (self::$alliancesContainer)
			return self::$alliancesContainer;
		
		self::$alliancesContainer = new DB_Container('alliances', 'Rakuun_DB_Alliance');
		self::$alliancesContainer->setConnection(self::getPersistentConnection());
		self::$alliancesContainer->addReferencedContainer(self::getMetasContainer(), 'meta', 'id');
		
		return self::$alliancesContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getMetasContainer() {
		if (self::$metasContainer)
			return self::$metasContainer;
		
		self::$metasContainer = new DB_Container('metas', 'Rakuun_DB_Meta');
		self::$metasContainer->setConnection(self::getPersistentConnection());
		
		return self::$metasContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBuildingsContainer() {
		if (self::$buildingsContainer)
			return self::$buildingsContainer;
			
		self::$buildingsContainer = new DB_Container('buildings', 'Rakuun_DB_Buildings');
		self::$buildingsContainer->setConnection(self::getPersistentConnection());
		self::$buildingsContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		
		return self::$buildingsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getTechnologiesContainer() {
		if (self::$technologiesContainer)
			return self::$technologiesContainer;
			
		self::$technologiesContainer = new DB_Container('technologies', 'Rakuun_DB_Technologies');
		self::$technologiesContainer->setConnection(self::getPersistentConnection());
		self::$technologiesContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		
		return self::$technologiesContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getUnitsContainer() {
		if (self::$unitsContainer)
			return self::$unitsContainer;
			
		self::$unitsContainer = new DB_Container('units');
		self::$unitsContainer->setConnection(self::getPersistentConnection());
		
		return self::$unitsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getLogUnitsProductionContainer() {
		if (self::$logUnitsProductionContainer)
			return self::$logUnitsProductionContainer;
			
		self::$logUnitsProductionContainer = new DB_Container('log_units_production');
		self::$logUnitsProductionContainer->setConnection(self::getPersistentConnection());
		
		return self::$logUnitsProductionContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getLogFightsContainer() {
		if (self::$logFightsContainer)
			return self::$logFightsContainer;
			
		self::$logFightsContainer = new DB_Container('log_fights');
		self::$logFightsContainer->setConnection(self::getPersistentConnection());
		self::$logFightsContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		self::$logFightsContainer->addReferencedContainer(self::getUserContainer(), 'opponent', 'id');
		
		return self::$logFightsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getLogUserRessourcetransferContainer() {
		if (self::$logUserRessourcetransferContainer)
			return self::$logUserRessourcetransferContainer;
			
		self::$logUserRessourcetransferContainer = new DB_Container('log_users_ressourcetransfer');
		self::$logUserRessourcetransferContainer->setConnection(self::getPersistentConnection());
		self::$logUserRessourcetransferContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		self::$logUserRessourcetransferContainer->addReferencedContainer(self::getUserContainer(), 'sender', 'id');
		
		return self::$logUserRessourcetransferContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getRoundInformationContainer() {
		if (self::$roundInformationContainer)
			return self::$roundInformationContainer;
		
		self::$roundInformationContainer = new DB_Container('round_information');
		self::$roundInformationContainer->setConnection(self::getPersistentConnection());
		
		return self::$roundInformationContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getNewsContainer() {
		if (self::$newsContainer)
			return self::$newsContainer;
			
		self::$newsContainer = new DB_Container('news');
		self::$newsContainer->setConnection(self::getPersistentConnection());
		
		return self::$newsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsGlobalContainer() {
		if (self::$boardsGlobalContainer)
			return self::$boardsGlobalContainer;
			
		self::$boardsGlobalContainer = new DB_Container('boards_global');
		self::$boardsGlobalContainer->setConnection(self::getPersistentConnection());
		
		return self::$boardsGlobalContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsGlobalPostingsContainer() {
		if (self::$boardsGlobalPostingsContainer)
			return self::$boardsGlobalPostingsContainer;
			
		self::$boardsGlobalPostingsContainer = new DB_Container('boards_global_postings');
		self::$boardsGlobalPostingsContainer->setConnection(self::getPersistentConnection());
		self::$boardsGlobalPostingsContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		self::$boardsGlobalPostingsContainer->addReferencedContainer(self::getUserContainer(), 'deleted_by', 'id');
		
		return self::$boardsGlobalPostingsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsGlobalLastVisitedContainer() {
		if (self::$boardsGlobalLastVisitedContainer)
			return self::$boardsGlobalLastVisitedContainer;
		
		self::$boardsGlobalLastVisitedContainer = new DB_Container('boards_global_visited');
		self::$boardsGlobalLastVisitedContainer->setConnection(self::getPersistentConnection());
		self::$boardsGlobalLastVisitedContainer->addReferencedContainer(self::getBoardsGlobalContainer());
		
		return self::$boardsGlobalLastVisitedContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getEternalUserContainer() {
		if (self::$eternalUserContainer)
			return self::$eternalUserContainer;
		
		self::$eternalUserContainer = new DB_Container('eternal_user');
		self::$eternalUserContainer->setConnection(self::getPersistentConnection());
		
		return self::$eternalUserContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getEternalUserUserAssocContainer() {
		if (self::$eternalUserUserAssocContainer)
			return self::$eternalUserUserAssocContainer;
		
		self::$eternalUserUserAssocContainer = new DB_Container('eternal_user_user_assoc');
		self::$eternalUserUserAssocContainer->setConnection(self::getPersistentConnection());
		
		return self::$eternalUserUserAssocContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getEternalUserAchievementContainer() {
		if (self::$eternalUserAchievementContainer)
			return self::$eternalUserAchievementContainer;
		
		self::$eternalUserAchievementContainer = new DB_Container('eternal_user_achievements');
		self::$eternalUserAchievementContainer->setConnection(self::getPersistentConnection());
		
		return self::$eternalUserAchievementContainer;
	}
	
	// -------------------------------------------------------------------------
	
	/**
	 * Returns DB_Connection for persistent data (not deleted after each round)
	 * @return DB_Connection
	 */
	public static function getPersistentConnection() {
		if (self::$persistentConnection)
			return self::$persistentConnection;

		if (DB_CONNECTION_PERSISTENT == DB_CONNECTION)
			throw new Core_Exception('Connection for persistent data must be different than connection for normal data.');
		
		self::$persistentConnection = new DB_Connection(DB_CONNECTION_PERSISTENT);

		return self::$persistentConnection;
	}
	
	public static function roundNameToPrefix($roundName) {
		return str_replace(' ', '_', Text::toLowerCase($roundName)).'_';
	}
}

?>