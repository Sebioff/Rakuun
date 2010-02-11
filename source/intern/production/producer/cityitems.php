<?php

/**
 * Class that is responsible for producing citys items
 */
class Rakuun_Intern_Production_Producer_CityItems extends Rakuun_Intern_Production_Producer {
	public function __construct(DB_Container $itemContainer, DB_Container $itemWIPContainer, Rakuun_DB_User $user = null) {
		if (!$user)
			$user = Rakuun_User_Manager::getCurrentUser();
		parent::__construct($itemContainer, $itemWIPContainer, $user, 'user');
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function addWIPItem(DB_Record $wipItem) {
		if ($this->getItemContainer()->getTable() == 'buildings')
			$wipObject = Rakuun_Intern_Production_Factory::getBuilding($wipItem->building, $this->getProductionTarget());
		else
			$wipObject = Rakuun_Intern_Production_Factory::getTechnology($wipItem->technology, $this->getProductionTarget());
		$newWip = new Rakuun_Intern_Production_WIP($wipObject->getInternalName().$wipItem->level, $this->getItemWIPContainer(), $wipObject);
		$newWip->setLevel($wipItem->level);
		$newWip->setStartTime($wipItem->starttime);
		$newWip->setRecord($wipItem);
		$this->wip[] = $newWip;
	}
}

?>