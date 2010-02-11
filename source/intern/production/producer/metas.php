<?php

/**
 * Class that is responsible for producing items for alliances
 */
class Rakuun_Intern_Production_Producer_Metas extends Rakuun_Intern_Production_Producer {
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function addWIPItem(DB_Record $wipItem) {
		$wipObject = Rakuun_Intern_Production_Factory_Metas::getBuilding($wipItem->building, $this->getProductionTarget());
		$newWip = new Rakuun_Intern_Production_WIP($wipObject->getInternalName().$wipItem->level, $this->getItemWIPContainer(), $wipObject);
		$newWip->setLevel($wipItem->level);
		$newWip->setStartTime($wipItem->starttime);
		$newWip->setRecord($wipItem);
		$this->wip[] = $newWip;
	}
	
	protected function onFinishedProduction(Rakuun_Intern_Production_Base $producedItem) {
		if ($producedItem->getInternalName() == 'dancertia') {
			$this->getProductionTarget()->dancertiaStarttime = time();
			$this->getProductionTarget()->save();
		}
	}
}

?>