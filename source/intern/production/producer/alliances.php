<?php

/**
 * Class that is responsible for producing items for alliances
 */
class Rakuun_Intern_Production_Producer_Alliances extends Rakuun_Intern_Production_Producer {
	public function __construct(Rakuun_DB_Alliance $alliance) {
		parent::__construct(Rakuun_DB_Containers::getAlliancesBuildingsContainer(), Rakuun_DB_Containers::getAlliancesBuildingsWIPContainer(), $alliance, 'alliance');
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function addWIPItem(DB_Record $wipItem) {
		$wipObject = Rakuun_Intern_Production_Factory_Alliances::getBuilding($wipItem->building, $this->getProductionTarget());
		$newWip = new Rakuun_Intern_Production_WIP($wipObject->getInternalName().$wipItem->level, $this->getItemWIPContainer(), $wipObject);
		$newWip->setLevel($wipItem->level);
		$newWip->setStartTime($wipItem->starttime);
		$newWip->setRecord($wipItem);
		$this->wip[] = $newWip;
	}
}

?>