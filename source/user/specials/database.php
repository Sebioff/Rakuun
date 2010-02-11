<?php

class Rakuun_User_Specials_Database extends Rakuun_User_Specials {
	private static $databaseIdentifiers = array(Rakuun_User_Specials::SPECIAL_DATABASE_BLUE, Rakuun_User_Specials::SPECIAL_DATABASE_BROWN, Rakuun_User_Specials::SPECIAL_DATABASE_GREEN, Rakuun_User_Specials::SPECIAL_DATABASE_RED, Rakuun_User_Specials::SPECIAL_DATABASE_YELLOW);
	
	public function giveSpecial() {
		$db = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->selectByIdentifierFirst($this->identifier);
		if ($db) {
			$db->user = $this->user;
			Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->save($db);
		} else {
			// fallback if this database belongs to no user yet.
			parent::giveSpecial();
		}
	}
	
	/**
	 * @return array of identifiers for databases that are visible for the given alliance
	 */
	public static function getVisibleDatabasesForAlliance(Rakuun_DB_Alliance $alliance = null) {
		if ($alliance)
			return array_slice(self::getDatabaseIdentifiers(), 0, $alliance->buildings->databaseDetector);
		else
			return array();
	}
	
	/**
	 * @return array of identifiers used for databases
	 */
	public static function getDatabaseIdentifiers() {
		return self::$databaseIdentifiers;
	}
}

?>