<?php

/**
 * Checks if the meta doesn't own a dancertia yet
 */
class Rakuun_Intern_Production_Requirement_Meta_GotNoDancertia extends Rakuun_Intern_Production_Requirement_Base {
	public function getDescription() {
		return 'Meta darf noch keine Dancertia besitzen / bauen';
	}
	
	public function fulfilled() {
		if (!$this->getProductionItem()->getOwner()->alliance || !$this->getProductionItem()->getOwner()->alliance->meta)
			return false;
		
		$dancertia = Rakuun_Intern_Production_Factory_Metas::getBuilding('dancertia');
		$options = array();
		$options['conditions'][] = array('meta = ? ', $this->getProductionItem()->getOwner()->alliance->meta);
		$options['conditions'][] = array('building = ? ', $dancertia->getInternalName());
		return ($dancertia->getLevel() == 0 && Rakuun_DB_Containers::getMetasBuildingsWIPContainer()->selectFirst($options) === null);
	}
}

?>