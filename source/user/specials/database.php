<?php

class Rakuun_User_Specials_Database extends Rakuun_User_Specials {
	private static $databaseIdentifiers = array(Rakuun_User_Specials::SPECIAL_DATABASE_BLUE, Rakuun_User_Specials::SPECIAL_DATABASE_BROWN, Rakuun_User_Specials::SPECIAL_DATABASE_GREEN, Rakuun_User_Specials::SPECIAL_DATABASE_RED, Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW);
	
	public function giveSpecial() {
		$db = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->selectByIdentifierFirst($this->identifier);
		if ($db) {
			// moved database inside of meta? -> reduce boni by 50%
			if ($db->user->alliance && $this->user->alliance
				&& (($db->user->alliance->getPK() == $this->user->alliance->getPK())
					|| ($db->user->alliance->meta && $this->user->alliance->meta && $db->user->alliance->meta->getPK() == $this->user->alliance->meta->getPK())
				)
			) {
				$param = $this->getParam(Rakuun_User_Specials::PARAM_DATABASE_MOVED);
				$this->setParam(Rakuun_User_Specials::PARAM_DATABASE_MOVED, round((time() + $param->value) / 2));
			}
			// not moved in meta -> set boni to zero
			else {
				$this->setParam(Rakuun_User_Specials::PARAM_DATABASE_MOVED, time());
			}
			$db->user = $this->user;
			Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->save($db);
		} else {
			// fallback if this database belongs to no user yet.
			$db = parent::giveSpecial();
			$this->setParam(Rakuun_User_Specials::PARAM_DATABASE_MOVED, time());
		}
		
		return $db;
	}
	
	public function hasSpecial() {
		// belongs to user?
		$special = $this->loadFromDB();
		if ($special && $special->active && $special->user->getPK() == $this->user->getPK()) {
			return true;
		}
			
		if (!$this->user->alliance)
			return false;
		
		// belongs to someone in the meta?
		$options = array();
		$userTable = Rakuun_DB_Containers::getUserContainer()->getTable();
		$allianceTable = Rakuun_DB_Containers::getAlliancesContainer()->getTable();
		$specialsUsersAssocTable = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->getTable();
		$options['join'] = array($userTable, $allianceTable);
		$options['group'] = $specialsUsersAssocTable.'.identifier';
		if (!$this->user->alliance->meta) {
			$options['conditions'][] = array($userTable.'.alliance = ?', $this->user->alliance);
		}
		else {
			$options['conditions'][] = array('('.$userTable.'.alliance = ?) OR ('.$userTable.'.alliance = '.$allianceTable.'.id && '.$allianceTable.'.meta = ?)', $this->user->alliance, $this->user->alliance->meta);
		}
		$options['conditions'][] = array($specialsUsersAssocTable.'.user = '.$userTable.'.id');
		$options['conditions'][] = array($specialsUsersAssocTable.'.identifier = ?', $this->identifier);
		$options['conditions'][] = array($specialsUsersAssocTable.'.active = ?', true);
		return (Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->selectFirst($options) !== null);
	}
	
	protected function loadFromDB() {
		$options['conditions'][] = array('identifier = ?', $this->identifier);
		return Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->selectFirst($options);
	}
	
	public function getEffectValue(Rakuun_DB_Alliance $alliance = null) {
		if (!$alliance)
			$alliance = $this->user->alliance;
			
		$detector = Rakuun_Intern_Production_Factory_Alliances::getDetectorForDatabase($this->identifier, $alliance);
		$effectValues = Rakuun_User_Specials::getEffectValues();
		$moveTime = $this->getParam(Rakuun_User_Specials::PARAM_DATABASE_MOVED)->value;
		return round((time() - $moveTime) / 60 / 60 / 24 * $effectValues[$this->identifier] * $detector->getLevel(), 4);
	}
	
	/**
	 * @return array of identifiers for databases that are visible for the given alliance
	 */
	public static function getVisibleDatabasesForAlliance(Rakuun_DB_Alliance $alliance = null) {
		if ($alliance) {
			$visibleDatabases = array();
			if ($alliance->buildings->databaseDetectorBlue)
				$visibleDatabases[] = Rakuun_User_Specials::SPECIAL_DATABASE_BLUE;
			if ($alliance->buildings->databaseDetectorBrown)
				$visibleDatabases[] = Rakuun_User_Specials::SPECIAL_DATABASE_BROWN;
			if ($alliance->buildings->databaseDetectorGreen)
				$visibleDatabases[] = Rakuun_User_Specials::SPECIAL_DATABASE_GREEN;
			if ($alliance->buildings->databaseDetectorRed)
				$visibleDatabases[] = Rakuun_User_Specials::SPECIAL_DATABASE_RED;
			if ($alliance->buildings->databaseDetectorYellow)
				$visibleDatabases[] = Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW;
			return $visibleDatabases;
		}
		else
			return array();
	}
	
	/**
	 * @return array of identifiers used for databases
	 */
	public static function getDatabaseIdentifiers() {
		return self::$databaseIdentifiers;
	}
	
	public static function getDatabaseImages() {
		return array(
			Rakuun_User_Specials::SPECIAL_DATABASE_BLUE => 'db_blue',
			Rakuun_User_Specials::SPECIAL_DATABASE_BROWN => 'db_brown',
			Rakuun_User_Specials::SPECIAL_DATABASE_GREEN => 'db_green',
			Rakuun_User_Specials::SPECIAL_DATABASE_RED => 'db_red',
			Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW => 'db_yellow'
		);
	}
}

?>