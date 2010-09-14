<?php

abstract class Rakuun_DB_Containers_Persistent {
	private static $userContainer = null;
	private static $alliancesContainer = null;
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
	public static function getAlliancesContainer() {
		if (self::$alliancesContainer)
			return self::$alliancesContainer;
		
		self::$alliancesContainer = new DB_Container('alliances', 'Rakuun_DB_Alliance');
		self::$alliancesContainer->setConnection(self::getPersistentConnection());
		
		return self::$alliancesContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBuildingsContainer() {
		if (self::$buildingsContainer)
			return self::$buildingsContainer;
			
		self::$buildingsContainer = new DB_Container('buildings', 'Rakuun_DB_Buildings');
		self::$buildingsContainer->setConnection(self::getPersistentConnection());
		
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
			
		//TODO: Move to rakuun-static-db
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
			
		//TODO: Move to rakuun-static-db
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
		
		// Has to stay in rakuun-round-db
		self::$boardsGlobalLastVisitedContainer = new DB_Container('boards_global_visited');
		self::$boardsGlobalLastVisitedContainer->setConnection(self::getPersistentConnection());
		self::$boardsGlobalLastVisitedContainer->addReferencedContainer(self::getBoardsGlobalContainer());
		
		return self::$boardsGlobalLastVisitedContainer;
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