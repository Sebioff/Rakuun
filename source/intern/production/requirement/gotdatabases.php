<?php

/**
 * Checks if the player owns 3 databases
 */
class Rakuun_Intern_Production_Requirement_GotDatabases implements Rakuun_Intern_Production_Requirement {
	public function getDescription() {
		return 'Du musst drei Datenbankteile besitzen';
	}
	
	public function fulfilled() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return $user->getDatabaseCount() >= 3;
	}
}

?>