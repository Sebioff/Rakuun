<?php

/**
 * Checks if the meta owns a space port
 */
class Rakuun_Intern_Production_Requirement_Meta_GotSpacePort implements Rakuun_Intern_Production_Requirement {
	public function getDescription() {
		return 'Meta muss einen Raumhafen besitzen';
	}
	
	public function fulfilled() {
		if (!Rakuun_User_Manager::getCurrentUser()->alliance || !Rakuun_User_Manager::getCurrentUser()->alliance->meta)
			return false;
		
		$spacePort = Rakuun_Intern_Production_Factory_Metas::getBuilding('space_port');
		return ($spacePort->getLevel() >= 1);
	}
}

?>