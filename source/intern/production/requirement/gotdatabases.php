<?php

/**
 * Checks if the player owns 3 databases
 */
class Rakuun_Intern_Production_Requirement_GotDatabases extends Rakuun_Intern_Production_Requirement_Base {
	public function getDescription() {
		return 'Du musst drei Datenbankteile besitzen';
	}
	
	public function fulfilled() {
		$user = $this->getProductionItem()->getOwner();
		return $user->getDatabaseCount() >= 3;
	}
}

?>