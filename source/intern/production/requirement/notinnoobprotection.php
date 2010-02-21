<?php

/**
 * Checks if the player is not in noob protection
 */
class Rakuun_Intern_Production_Requirement_NotInNoobProtection extends Rakuun_Intern_Production_Requirement_Base {
	public function getDescription() {
		return 'Du darfst dich nicht im Noobschutz befinden';
	}
	
	public function fulfilled() {
		$user = $this->getProductionItem()->getOwner();
		return !$user->isInNoob();
	}
}

?>