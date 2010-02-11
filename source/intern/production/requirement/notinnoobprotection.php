<?php

/**
 * Checks if the player is not in noob protection
 */
class Rakuun_Intern_Production_Requirement_NotInNoobProtection implements Rakuun_Intern_Production_Requirement {
	public function getDescription() {
		return 'Du darfst dich nicht im Noobschutz befinden';
	}
	
	public function fulfilled() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return !$user->isInNoob();
	}
}

?>