<?php

/**
 * Checks if at least one player of the meta owns a shield generator
 */
class Rakuun_Intern_Production_Requirement_Meta_GotShieldGenerator implements Rakuun_Intern_Production_Requirement {
	public function getDescription() {
		return 'Mindestens ein Spieler der Meta muss einen Schildgenerator besitzen';
	}
	
	public function fulfilled() {
		return Rakuun_User_Manager::getCurrentUser()->alliance->meta->hasMemberWithShieldGenerator();
	}
}

?>