<?php

/**
 * Parent class for all Modules belonging to this project.
 */
class Rakuun_Module extends Module {
	const PAGETITLE = 'Rakuun, das SciFi-Browsergame';
	
	public function init() {
		parent::init();
		
		$this->addCssRouteReference('core_css', 'reset.css');
		$this->addCssRouteReference('css', 'default.css');
		$this->addJsRouteReference('js', 'main.js');
		$this->mainPanel->setPageTitle(self::PAGETITLE);
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	public function setPageTitle($title) {
		$this->mainPanel->setPageTitle($title.' - '.self::PAGETITLE);
	}
	
	/**
	 * Called if the project is in maintenance mode.
	 */
	public static function maintenanceMode() {
		require dirname(__FILE__).'/maintenancemode.tpl';
		exit;
	}
	
	/**
	 * Called if an error occurs.
	 */
	public static function onError(array $backtrace, $customMessage = '', $errorType = '') {
		try {
			// developers see errors
			if (Rakuun_TeamSecurity::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_TeamSecurity::GROUP_DEVELOPER)) {
				Core_BacktracePrinter::printBacktrace($backtrace, $customMessage, $errorType);
				return;
			}
		}
		catch (Core_Exception $ce) {
			/* Whoops, something went wrong. Either there is no logged in user or
			 * we cant connect to the database. Anyway, we don't want to produce
			 * any new errors here so we just silently catch the exception in order
			 * to be at least able to print an error message for the user.
			 */
		}
		
		$notificationSuccessful = false;
		try {
			IO_Log::get()->error($errorType.'! '.$customMessage);
			$notificationSuccessful = true;
		}
		catch (Core_Exception $ce) {
			// Logging into logfile not possible
		}
		
		try {
			// notify all developers by mail
			if ($customMessage)
				$subject = $customMessage;
			else
				$subject = 'Fehler auf LIVE';
			
			Rakuun_Game::sendErrorMail($backtrace, $customMessage, $errorType, $subject);
			$notificationSuccessful = true;
		}
		catch (Core_Exception $ce) {
			// Sending errormails failed
		}
		
		if ($notificationSuccessful)
			require dirname(__FILE__).'/error.tpl';
		else
			echo 'Es ist ein schwerwiegender interner Fehler aufgetreten. Bitte benachrichtige einen Admin.';
	}
	
	/**
	 * Called if the project gets reset.
	 */
	public static function onSetup() {
		foreach (Rakuun_User_Specials_Database::getDatabaseIdentifiers() as $identifier) {
			$record = new DB_Record();
			$record->identifier = $identifier;
			$coordinateGenerator = new Rakuun_Intern_Map_CoordinateGenerator();
			$startPosition = $coordinateGenerator->getRandomFreeCoordinate();
			$record->positionX = $startPosition[0];
			$record->positionY = $startPosition[1];
			Rakuun_DB_Containers::getDatabasesStartpositionsContainer()->save($record);
		}
		
		// TODO remove this standard data (only used for testing purposes)
		$testUser = Rakuun_DB_Containers::getUserContainer()->selectByPK(1);
		Rakuun_GameSecurity::get()->addToGroup($testUser, Rakuun_GameSecurity::get()->getGroup(Rakuun_GameSecurity::GROUP_TEAM));
		Rakuun_GameSecurity::get()->addToGroup($testUser, Rakuun_GameSecurity::get()->getGroup(Rakuun_GameSecurity::GROUP_SPONSORS));
		Rakuun_TeamSecurity::get()->addToGroup($testUser, Rakuun_TeamSecurity::get()->getGroup(Rakuun_TeamSecurity::GROUP_ADMINS));
		Rakuun_TeamSecurity::get()->addToGroup($testUser, Rakuun_TeamSecurity::get()->getGroup(Rakuun_TeamSecurity::GROUP_USERMANAGERS));
		
		// Remove upload directory and its content
		IO_Utils::deleteFolder(GUI_Control_FileUpload::getUploadDirectory());
	}
}

?>