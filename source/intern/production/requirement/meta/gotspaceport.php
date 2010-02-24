<?php

/**
 * Checks if the meta owns a space port
 */
class Rakuun_Intern_Production_Requirement_Meta_GotSpacePort extends Rakuun_Intern_Production_Requirement_Base {
	public function getDescription() {
		return 'Meta muss einen Raumhafen besitzen';
	}
	
	public function fulfilled() {
		if (!$this->getProductionItem()->getOwner()->alliance || !$this->getProductionItem()->getOwner()->alliance->meta)
			return false;
		
		$spacePort = Rakuun_Intern_Production_Factory_Metas::getBuilding('space_port', $this->getProductionItem()->getOwner()->alliance->meta);
		return ($spacePort->getLevel() >= 1);
	}
}

?>