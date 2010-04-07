<?php

/*
 * TODO not really the best place to do this...though, it needs to be done before
 * ANY container is accessed. Maybe find a better place?
 */
DB_Container::addReferencedContainerGlobal(Rakuun_DB_Containers::getUserContainer());

abstract class Rakuun_DB_Containers {
	private static $userContainer = null;
	private static $userDeletedContainer = null;
	private static $userActivationContainer = null;
	private static $ressourcesContainer = null;
	private static $buildingsContainer = null;
	private static $buildingsWIPContainer = null;
	private static $buildingsWorkersContainer = null;
	private static $technologiesContainer = null;
	private static $technologiesWIPContainer = null;
	private static $logUnitsProductionContainer = null;
	private static $logFightsContainer = null;
	private static $logSpiesContainer = null;
	private static $unitsContainer = null;
	private static $unitsWIPContainer = null;
	private static $alliancesContainer = null;
	private static $alliancesApplicationsContainer = null;
	private static $alliancesAccountlogContainer = null;
	private static $alliancesBuildingsContainer = null;
	private static $alliancesBuildingsWIPContainer = null;
	private static $boardsContainer = null;
	private static $boardsPostingsContainer = null;
	private static $boardsLastVisitedContainer = null;
	private static $boardsAllianceContainer = null;
	private static $boardsAlliancePostingsContainer = null;
	private static $boardsAllianceLastVisitedContainer = null;
	private static $boardsMetaContainer = null;
	private static $boardsMetaPostingsContainer = null;
	private static $boardsMetaLastVisitedContainer = null;
	private static $alliancesDiplomaciesContainer = null;
	private static $metasContainer = null;
	private static $metasApplicationsContainer = null;
	private static $metasAccountlogContainer = null;
	private static $metasBuildingsContainer = null;
	private static $metasBuildingsWIPContainer = null;
	private static $logUserActivityContainer = null;
	private static $logUserRessourcetransferContainer = null;
	private static $messagesContainer = null;
	private static $newsContainer = null;
	private static $pollsContainer = null;
	private static $pollsAnswersContainer = null;
	private static $pollsAnswersUsersAssocContainer = null;
	private static $shoutboxContainer = null;
	private static $shoutboxAlliancesContainer = null;
	private static $shoutboxMetasContainer = null;
	private static $cautionContainer = null;
	private static $specialsUsersAssocContainer = null;
	private static $specialsParamsContainer = null;
	private static $logBuildingsContainer = null;
	private static $logTechnologiesContainer = null;
	private static $logMultiactionsContainer = null;
	private static $logMultiactionsUsersAssocContainer = null;
	private static $userCallbacksContainer = null;
	private static $supportticketsContainer = null;
	private static $usersDirectoryArmyGroups = null;
	private static $usersDirectoryArmyGroupsAssoc = null;
	private static $usersDirectoryMessagesGroups = null;
	private static $usersDirectoryMessagesGroupsAssoc = null;
	private static $tutorContainer = null;
	private static $armiesContainer = null;
	private static $armiesTechnologiesContainer = null;
	private static $armiesPathsContainer = null;
	private static $cronjobsContainer = null;
	private static $stockmarketContainer = null;
	private static $databasesStartpositionsContainer = null;
	private static $questsContainer = null;
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Container
	 */
	public static function getUserContainer() {
		if (self::$userContainer)
			return self::$userContainer;
			
		self::$userContainer = new DB_Container('users', 'Rakuun_DB_User');
		self::$userContainer->addReferencedContainer(self::getAlliancesContainer());
		// TODO use lambda-function with PHP 5.3
		self::$userContainer->addDeleteCallback('Rakuun_DB_Containers::onUserDelete');
		
		return self::$userContainer;
	}
	
	// TODO remove with PHP 5.3 (use lambda-function instead)
	public static function onUserDelete(Rakuun_DB_User $user = null) {
		if ($user === null)
			return;
		
		// FIXME not permitted
//		if ($user->picture)
//			IO_Utils::deleteFolder(dirname($user->picture));
		
		if ($user->alliance && Rakuun_DB_Containers::getUserContainer()->countByAlliance($user->alliance) == 0) {
			// delete alliance if last user is deleted
			Rakuun_DB_Containers::getAlliancesContainer()->delete($user->alliance);
		}
		
		$deletedUser = new DB_Record();
		$deletedUser->id = $user->getPK();
		$deletedUser->name = $user->nameUncolored;
		$deletedUser->nameColored = $user->nameColored;
		$deletedUser->mail = $user->mail;
		
		self::getUserDeletedContainer()->save($deletedUser);
		
		//remove this user as sitter and his notice
		$sitted = Rakuun_DB_Containers::getUserContainer()->selectBySitterFirst($user);
		if ($sitted) {
			$sitted->sitter = null;
			$sitted->sitterNotice = '';
			$sitted->save();
		}
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getUserDeletedContainer() {
		if (self::$userDeletedContainer)
			return self::$userDeletedContainer;
			
		self::$userDeletedContainer = new DB_Container('users_deleted', 'Rakuun_DB_User');
		
		return self::$userDeletedContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getUserActivationContainer() {
		if (self::$userActivationContainer)
			return self::$userActivationContainer;
			
		self::$userActivationContainer = new DB_Container('users_activations');
		
		return self::$userActivationContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getRessourcesContainer() {
		if (self::$ressourcesContainer)
			return self::$ressourcesContainer;
			
		self::$ressourcesContainer = new DB_Container('ressources', 'Rakuun_DB_Ressources');
		self::$ressourcesContainer->enableOptimisticLockingForProperties(array('iron', 'beryllium', 'energy', 'people', 'tick'));
		
		return self::$ressourcesContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBuildingsContainer() {
		if (self::$buildingsContainer)
			return self::$buildingsContainer;
			
		self::$buildingsContainer = new DB_Container('buildings', 'Rakuun_DB_Buildings');
		self::$buildingsContainer->enableOptimisticLockingForProperties();
		
		return self::$buildingsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBuildingsWIPContainer() {
		if (self::$buildingsWIPContainer)
			return self::$buildingsWIPContainer;
			
		self::$buildingsWIPContainer = new DB_Container('buildings_wip');
		
		return self::$buildingsWIPContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBuildingsWorkersContainer() {
		if (self::$buildingsWorkersContainer)
			return self::$buildingsWorkersContainer;
			
		self::$buildingsWorkersContainer = new DB_Container('buildings_workers');
		
		return self::$buildingsWorkersContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getTechnologiesContainer() {
		if (self::$technologiesContainer)
			return self::$technologiesContainer;
			
		self::$technologiesContainer = new DB_Container('technologies', 'Rakuun_DB_Technologies');
		self::$technologiesContainer->enableOptimisticLockingForProperties();
		
		return self::$technologiesContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getTechnologiesWIPContainer() {
		if (self::$technologiesWIPContainer)
			return self::$technologiesWIPContainer;
			
		self::$technologiesWIPContainer = new DB_Container('technologies_wip');
		
		return self::$technologiesWIPContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getUnitsContainer() {
		if (self::$unitsContainer)
			return self::$unitsContainer;
			
		self::$unitsContainer = new DB_Container('units');
		self::$unitsContainer->enableOptimisticLockingForProperties();
		
		return self::$unitsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getUnitsWIPContainer() {
		if (self::$unitsWIPContainer)
			return self::$unitsWIPContainer;
			
		self::$unitsWIPContainer = new DB_Container('units_wip');
		
		return self::$unitsWIPContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getAlliancesContainer() {
		if (self::$alliancesContainer)
			return self::$alliancesContainer;
			
		self::$alliancesContainer = new DB_Container('alliances', 'Rakuun_DB_Alliance');
		self::$alliancesContainer->addReferencedContainer(self::getMetasContainer());
		self::$alliancesContainer->addDeleteCallback('Rakuun_DB_Containers::onAllianceDelete');
		
		return self::$alliancesContainer;
	}
	
	// TODO remove with PHP 5.3 (use lambda-function instead)
	public static function onAllianceDelete(DB_Record $alliance = null) {
		if ($alliance) {
			if ($alliance->meta && Rakuun_DB_Containers::getAlliancesContainer()->countByMeta($alliance->meta) == 1) {
				// delete meta after last alliance left
				Rakuun_DB_Containers::getMetasContainer()->delete($alliance->meta);
			}
			
			if ($alliance->picture) {
				IO_Utils::deleteFolder(dirname($alliance->picture));
			}
		}
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getAlliancesApplicationsContainer() {
		if (self::$alliancesApplicationsContainer)
			return self::$alliancesApplicationsContainer;
			
		self::$alliancesApplicationsContainer = new DB_Container('alliances_applications');
		
		return self::$alliancesApplicationsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getAlliancesBuildingsContainer() {
		if (self::$alliancesBuildingsContainer)
			return self::$alliancesBuildingsContainer;
			
		self::$alliancesBuildingsContainer = new DB_Container('alliances_buildings', 'Rakuun_DB_CityItems');
		
		return self::$alliancesBuildingsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getAlliancesBuildingsWIPContainer() {
		if (self::$alliancesBuildingsWIPContainer)
			return self::$alliancesBuildingsWIPContainer;
			
		self::$alliancesBuildingsWIPContainer = new DB_Container('alliances_buildings_wip');
		
		return self::$alliancesBuildingsWIPContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getAlliancesDiplomaciesContainer() {
		if (self::$alliancesDiplomaciesContainer)
			return self::$alliancesDiplomaciesContainer;
			
		self::$alliancesDiplomaciesContainer = new DB_Container('alliances_diplomacy');
		self::$alliancesDiplomaciesContainer->addReferencedContainer(self::getAlliancesContainer());
		return self::$alliancesDiplomaciesContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getAlliancesAccountlogContainer() {
		if (self::$alliancesAccountlogContainer)
			return self::$alliancesAccountlogContainer;
			
		self::$alliancesAccountlogContainer = new DB_Container('alliances_accountlog');
		self::$alliancesAccountlogContainer->addReferencedContainer(self::getAlliancesContainer());
		self::$alliancesAccountlogContainer->addReferencedContainer(self::getUserContainer(), 'sender', 'id');
		self::$alliancesAccountlogContainer->addReferencedContainer(self::getUserContainer(), 'receiver', 'id');
		return self::$alliancesAccountlogContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getMetasContainer() {
		if (self::$metasContainer)
			return self::$metasContainer;
			
		self::$metasContainer = new DB_Container('metas', 'Rakuun_DB_Meta');
		self::$metasContainer->addDeleteCallback('Rakuun_DB_Containers::onMetaDelete');
		
		return self::$metasContainer;
	}
	
	// TODO remove with PHP 5.3 (use lambda-function instead)
	public static function onMetaDelete(Rakuun_DB_Meta $meta = null) {
		if ($meta && $meta->picture) {
			IO_Utils::deleteFolder(dirname($meta->picture));
		}
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getMetasApplicationsContainer() {
		if (self::$metasApplicationsContainer)
			return self::$metasApplicationsContainer;
			
		self::$metasApplicationsContainer = new DB_Container('metas_applications');
		
		return self::$metasApplicationsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getMetasBuildingsContainer() {
		if (self::$metasBuildingsContainer)
			return self::$metasBuildingsContainer;
			
		self::$metasBuildingsContainer = new DB_Container('metas_buildings', 'Rakuun_DB_CityItems');
		
		return self::$metasBuildingsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getMetasBuildingsWIPContainer() {
		if (self::$metasBuildingsWIPContainer)
			return self::$metasBuildingsWIPContainer;
			
		self::$metasBuildingsWIPContainer = new DB_Container('metas_buildings_wip');
		
		return self::$metasBuildingsWIPContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getLogUserActivityContainer() {
		if (self::$logUserActivityContainer)
			return self::$logUserActivityContainer;
			
		self::$logUserActivityContainer = new DB_Container('log_users_activity');
		
		return self::$logUserActivityContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getLogUserRessourcetransferContainer() {
		if (self::$logUserRessourcetransferContainer)
			return self::$logUserRessourcetransferContainer;
			
		self::$logUserRessourcetransferContainer = new DB_Container('log_users_ressourcetransfer');
		self::$logUserRessourcetransferContainer->addReferencedContainer(self::getUserContainer(), 'sender', 'id');
		
		return self::$logUserRessourcetransferContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getLogUnitsProductionContainer() {
		if (self::$logUnitsProductionContainer)
			return self::$logUnitsProductionContainer;
			
		self::$logUnitsProductionContainer = new DB_Container('log_units_production');
		
		return self::$logUnitsProductionContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getLogFightsContainer() {
		if (self::$logFightsContainer)
			return self::$logFightsContainer;
			
		self::$logFightsContainer = new DB_Container('log_fights');
		self::$logFightsContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		self::$logFightsContainer->addReferencedContainer(self::getUserContainer(), 'opponent', 'id');
		
		return self::$logFightsContainer;
	}
	
		/**
	 * @return DB_Container
	 */
	public static function getLogSpiesContainer() {
		if (self::$logSpiesContainer)
			return self::$logSpiesContainer;
			
		self::$logSpiesContainer = new DB_Container('log_spies');
		self::$logSpiesContainer->addReferencedContainer(self::getUserContainer(), 'spied_user', 'id');
		
		return self::$logSpiesContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getMessagesContainer() {
		if (self::$messagesContainer)
			return self::$messagesContainer;
			
		self::$messagesContainer = new DB_Container('messages', 'Rakuun_Intern_IGM');
		
		return self::$messagesContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getMetasAccountlogContainer() {
		if (self::$metasAccountlogContainer)
			return self::$metasAccountlogContainer;
			
		self::$metasAccountlogContainer = new DB_Container('metas_accountlog');
		self::$metasAccountlogContainer->addReferencedContainer(self::getAlliancesContainer());
		self::$metasAccountlogContainer->addReferencedContainer(self::getMetasContainer());
		return self::$metasAccountlogContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getNewsContainer() {
		if (self::$newsContainer)
			return self::$newsContainer;
			
		self::$newsContainer = new DB_Container('news');
		
		return self::$newsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getPollsContainer() {
		if (self::$pollsContainer)
			return self::$pollsContainer;
			
		self::$pollsContainer = new DB_Container('polls');
		
		return self::$pollsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getPollsAnswersContainer() {
		if (self::$pollsAnswersContainer)
			return self::$pollsAnswersContainer;
			
		self::$pollsAnswersContainer = new DB_Container('polls_answers');
		
		return self::$pollsAnswersContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getPollsAnswersUsersAssocContainer() {
		if (self::$pollsAnswersUsersAssocContainer)
			return self::$pollsAnswersUsersAssocContainer;
			
		self::$pollsAnswersUsersAssocContainer = new DB_Container('polls_answers_users_assoc');
		
		return self::$pollsAnswersUsersAssocContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getShoutboxContainer() {
		if (self::$shoutboxContainer)
			return self::$shoutboxContainer;
		
		self::$shoutboxContainer = new DB_Container('shoutbox');
		self::$shoutboxContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		
		return self::$shoutboxContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getShoutboxAlliancesContainer() {
		if (self::$shoutboxAlliancesContainer)
			return self::$shoutboxAlliancesContainer;
		
		self::$shoutboxAlliancesContainer = new DB_Container('shoutbox_alliances');
		self::$shoutboxAlliancesContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		self::$shoutboxAlliancesContainer->addReferencedContainer(self::getAlliancesContainer());
		
		return self::$shoutboxAlliancesContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getShoutboxMetasContainer() {
		if (self::$shoutboxMetasContainer)
			return self::$shoutboxMetasContainer;
		
		self::$shoutboxMetasContainer = new DB_Container('shoutbox_metas');
		self::$shoutboxMetasContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		self::$shoutboxMetasContainer->addReferencedContainer(self::getMetasContainer());
		
		return self::$shoutboxMetasContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getCautionContainer() {
		if (self::$cautionContainer)
			return self::$cautionContainer;
		
		self::$cautionContainer = new DB_Container('cautions');
		
		return self::$cautionContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getSpecialsUsersAssocContainer() {
		if (self::$specialsUsersAssocContainer)
			return self::$specialsUsersAssocContainer;
		
		self::$specialsUsersAssocContainer = new DB_Container('specials_users_assoc');
		
		return self::$specialsUsersAssocContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getSpecialsParamsContainer() {
		if (self::$specialsParamsContainer)
			return self::$specialsParamsContainer;
		
		self::$specialsParamsContainer = new DB_Container('specials_params');
		self::$specialsParamsContainer->addReferencedContainer(self::getSpecialsUsersAssocContainer());
		
		return self::$specialsParamsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getLogBuildingsContainer() {
		if (self::$logBuildingsContainer)
			return self::$logBuildingsContainer;
		
		self::$logBuildingsContainer = new DB_Container('log_buildings');
		self::$logBuildingsContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		self::$logBuildingsContainer->addReferencedContainer(self::getUserContainer(), 'executing_user', 'id');
		
		return self::$logBuildingsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getLogTechnologiesContainer() {
		if (self::$logTechnologiesContainer)
			return self::$logTechnologiesContainer;
		
		self::$logTechnologiesContainer = new DB_Container('log_technologies');
		self::$logTechnologiesContainer->addReferencedContainer(self::getSpecialsUsersAssocContainer());
		
		return self::$logTechnologiesContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getLogMultiactionsContainer() {
		if (self::$logMultiactionsContainer)
			return self::$logMultiactionsContainer;
		
		self::$logMultiactionsContainer = new DB_Container('log_multiactions');
		
		return self::$logMultiactionsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getLogMultiactionsUsersAssocContainer() {
		if (self::$logMultiactionsUsersAssocContainer)
			return self::$logMultiactionsUsersAssocContainer;
		
		self::$logMultiactionsUsersAssocContainer = new DB_Container('log_multiactions_users_assoc');
		self::$logMultiactionsUsersAssocContainer->addReferencedContainer(self::getLogMultiactionsContainer());
		
		return self::$logMultiactionsUsersAssocContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getUserCallbacksContainer() {
		if (self::$userCallbacksContainer)
			return self::$userCallbacksContainer;
		
		self::$userCallbacksContainer = new DB_Container('users_callbacks');
		
		return self::$userCallbacksContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getSupportticketsContainer() {
		if (self::$supportticketsContainer)
			return self::$supportticketsContainer;
		
		self::$supportticketsContainer = new DB_Container('supporttickets');
		self::$supportticketsContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		
		return self::$supportticketsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getUsersDirectoryArmyGroupsContainer() {
		if (self::$usersDirectoryArmyGroups)
			return self::$usersDirectoryArmyGroups;
		
		self::$usersDirectoryArmyGroups = new DB_Container('users_directory_army_groups');
		
		return self::$usersDirectoryArmyGroups;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getUsersDirectoryArmyGroupsAssocContainer() {
		if (self::$usersDirectoryArmyGroupsAssoc)
			return self::$usersDirectoryArmyGroupsAssoc;
		
		self::$usersDirectoryArmyGroupsAssoc = new DB_Container('users_directory_army_groups_assoc');
		self::$usersDirectoryArmyGroupsAssoc->addReferencedContainer(self::getUsersDirectoryArmyGroupsContainer());
		
		return self::$usersDirectoryArmyGroupsAssoc;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getUsersDirectoryMessagesGroupsContainer() {
		if (self::$usersDirectoryMessagesGroups)
			return self::$usersDirectoryMessagesGroups;
		
		self::$usersDirectoryMessagesGroups = new DB_Container('users_directory_messages_groups');
		
		return self::$usersDirectoryMessagesGroups;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getUsersDirectoryMessagesGroupsAssocContainer() {
		if (self::$usersDirectoryMessagesGroupsAssoc)
			return self::$usersDirectoryMessagesGroupsAssoc;
		
		self::$usersDirectoryMessagesGroupsAssoc = new DB_Container('users_directory_messages_groups_assoc');
		self::$usersDirectoryMessagesGroupsAssoc->addReferencedContainer(self::getUsersDirectoryMessagesGroupsContainer());
		
		return self::$usersDirectoryMessagesGroupsAssoc;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getTutorContainer() {
		if (self::$tutorContainer)
			return self::$tutorContainer;
		
		self::$tutorContainer = new DB_Container('tutor');
		
		return self::$tutorContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getArmiesContainer() {
		if (self::$armiesContainer)
			return self::$armiesContainer;
		
		self::$armiesContainer = new DB_Container('armies');
		self::$armiesContainer->addReferencedContainer(self::getUserContainer(), 'target', 'id');
		// TODO use lambda-function with PHP 5.3
		self::$armiesContainer->addDeleteCallback('Rakuun_DB_Containers::onArmyDelete');
		
		return self::$armiesContainer;
	}
	
	// TODO remove with PHP 5.3 (use lambda-function instead)
	public static function onArmyDelete(DB_Record $army = null) {
		self::getArmiesTechnologiesContainer()->deleteByID($army->technologies);
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getArmiesTechnologiesContainer() {
		if (self::$armiesTechnologiesContainer)
			return self::$armiesTechnologiesContainer;
		
		self::$armiesTechnologiesContainer = new DB_Container('armies_technologies');
		
		return self::$armiesTechnologiesContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getArmiesPathsContainer() {
		if (self::$armiesPathsContainer)
			return self::$armiesPathsContainer;
		
		self::$armiesPathsContainer = new DB_Container('armies_paths');
		
		return self::$armiesPathsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getCronjobsContainer() {
		if (self::$cronjobsContainer)
			return self::$cronjobsContainer;
		
		self::$cronjobsContainer = new DB_Container('cronjobs');
		
		return self::$cronjobsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getStockmarketContainer() {
		if (self::$stockmarketContainer)
			return self::$stockmarketContainer;
		
		self::$stockmarketContainer = new DB_Container('stockmarket');
		
		return self::$stockmarketContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getDatabasesStartpositionsContainer() {
		if (self::$databasesStartpositionsContainer)
			return self::$databasesStartpositionsContainer;
		
		self::$databasesStartpositionsContainer = new DB_Container('databases_startpositions');
		
		return self::$databasesStartpositionsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsContainer() {
		if (self::$boardsContainer)
			return self::$boardsContainer;
			
		self::$boardsContainer = new DB_Container('boards');
		
		return self::$boardsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsPostingsContainer() {
		if (self::$boardsPostingsContainer)
			return self::$boardsPostingsContainer;
			
		self::$boardsPostingsContainer = new DB_Container('boards_postings');
		self::$boardsPostingsContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		
		return self::$boardsPostingsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsLastVisitedContainer() {
		if (self::$boardsLastVisitedContainer)
			return self::$boardsLastVisitedContainer;
		
		self::$boardsLastVisitedContainer = new DB_Container('boards_visited');
		self::$boardsLastVisitedContainer->addReferencedContainer(self::getBoardsContainer());
		
		return self::$boardsLastVisitedContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsAllianceContainer() {
		if (self::$boardsAllianceContainer)
			return self::$boardsAllianceContainer;
			
		self::$boardsAllianceContainer = new DB_Container('boards_alliance');
		
		return self::$boardsAllianceContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsAlliancePostingsContainer() {
		if (self::$boardsAlliancePostingsContainer)
			return self::$boardsAlliancePostingsContainer;
			
		self::$boardsAlliancePostingsContainer = new DB_Container('boards_alliance_postings');
		self::$boardsAlliancePostingsContainer->addReferencedContainer(self::getBoardsAllianceContainer());
		self::$boardsAlliancePostingsContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		
		return self::$boardsAlliancePostingsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsAllianceLastVisitedContainer() {
		if (self::$boardsAllianceLastVisitedContainer)
			return self::$boardsAllianceLastVisitedContainer;
		
		self::$boardsAllianceLastVisitedContainer = new DB_Container('boards_alliance_visited');
		self::$boardsAllianceLastVisitedContainer->addReferencedContainer(self::getBoardsAllianceContainer());
		
		return self::$boardsAllianceLastVisitedContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsMetaContainer() {
		if (self::$boardsMetaContainer)
			return self::$boardsMetaContainer;
			
		self::$boardsMetaContainer = new DB_Container('boards_meta');
		
		return self::$boardsMetaContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsMetaPostingsContainer() {
		if (self::$boardsMetaPostingsContainer)
			return self::$boardsMetaPostingsContainer;
			
		self::$boardsMetaPostingsContainer = new DB_Container('boards_meta_postings');
		self::$boardsMetaPostingsContainer->addReferencedContainer(self::getBoardsMetaContainer());
		self::$boardsMetaPostingsContainer->addReferencedContainer(self::getUserContainer(), 'user', 'id');
		
		return self::$boardsMetaPostingsContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getBoardsMetaLastVisitedContainer() {
		if (self::$boardsMetaLastVisitedContainer)
			return self::$boardsMetaLastVisitedContainer;
		
		self::$boardsMetaLastVisitedContainer = new DB_Container('boards_meta_visited');
		self::$boardsMetaLastVisitedContainer->addReferencedContainer(self::getBoardsMetaContainer());
		
		return self::$boardsMetaLastVisitedContainer;
	}
	
	/**
	 * @return DB_Container
	 */
	public static function getQuestsContainer() {
		if (self::$questsContainer)
			return self::$questsContainer;
		
		self::$questsContainer = new DB_Container('quests');
		
		return self::$questsContainer;
	}
}

?>