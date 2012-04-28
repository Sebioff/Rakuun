<?php

/**
 * Class that is responsible for producing units
 */
class Rakuun_Intern_Production_Producer_Units extends Rakuun_Intern_Production_Producer {
	private $unitsHaveBeenProduced = false;
	
	public function __construct(DB_Container $itemContainer, DB_Container $itemWIPContainer, Rakuun_DB_User $user = null) {
		if (!$user)
			$user = Rakuun_User_Manager::getCurrentUser();
		parent::__construct($itemContainer, $itemWIPContainer, $user, 'user');
		
		if ($this->unitsHaveBeenProduced) {
			$user->reachNoob();
		}
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function produce() {
		if (!$this->getWIP() || $this->getProductionTarget()->productionPaused)
			return;
			
		$wipItems = $this->getWIP();
		$firstItem = $wipItems[0];
		
		// pause production if requirements fail
		if ($this->getPauseOnMissingRequirements() && !$firstItem->getWIPItem()->meetsTechnicalRequirements()) {
			foreach ($this->getWIP() as $wipItem) {
				$wipItem->getRecord()->starttime = time();
				$wipItem->getRecord()->save();
			}
			return;
		}
		
		if ($firstItem->getRemainingTime() <= 0) {
			DB_Connection::get()->beginTransaction();
			$options = array();
			$options['lock'] = DB_Container::LOCK_FOR_UPDATE;
			$userUnits = $this->getItemContainer()->selectByUserFirst($firstItem->getUser(), $options);
			$finishedAmount = $firstItem->getAmountOfFinishedUnits();
			if ($finishedAmount >= $firstItem->getAmount()) {
				// remove from wips container
				$this->getItemWIPContainer()->delete($firstItem->getRecord());
				$finishedAmount = $firstItem->getAmount();
				// remove from internal wip-list
				array_shift($wipItems);
			}
			else {
				$firstItem->getRecord()->amount -= $finishedAmount;
				$firstItem->getRecord()->starttime = time() - (time() - $firstItem->getRecord()->starttime - $finishedAmount * $firstItem->getTimeCosts(1));
				$firstItem->getRecord()->save();
				$firstItem->setStartTime($firstItem->getRecord()->starttime);
				$firstItem->setAmount($firstItem->getRecord()->amount);
			}
			// count users units up
			$userUnits->{Text::underscoreToCamelCase($firstItem->getInternalName())} += $finishedAmount;
			$userUnits->save();
			// log production
			Rakuun_Intern_Log_UnitsProduction::log($firstItem->getUser(), $firstItem->getInternalName(), $finishedAmount);
			//update remaining unitWIPs to new starttime
			foreach ($wipItems as $wipItem) {
				if ($wipItem->getRecord()->getPK() == $firstItem->getRecord()->getPK())
					continue;
				$wipItem->getRecord()->starttime = time() + $firstItem->getTotalRemainingTime();
				$wipItem->getRecord()->save();
				$wipItem->setStartTime($wipItem->getRecord()->starttime);
				$wipItem->setAmount($wipItem->getRecord()->amount);
			}

			if (DB_Connection::get()->commit()) {
				// update internal wip-list with the list that got one item less
				$this->wip = $wipItems;
				$this->unitsHaveBeenProduced = true;
				$this->produce();
			}
		}
	}

	public function addWIPItem(DB_Record $wipItem) {
		$newWip = new Rakuun_Intern_Production_WIP_Unit($wipItem->getPK(), $this, Rakuun_Intern_Production_Factory::getUnit($wipItem->unit, $this->getProductionTarget()));
//		if ($i <= 1)
//			$newWip->removePanel($newWip->moveUp);
//		if ($i >= $wipItemsCount - 1)
//			$newWip->removePanel($newWip->moveDown);
		$newWip->setAmount($wipItem->amount);
		$newWip->setStartTime($wipItem->starttime);
		$newWip->setRecord($wipItem);
		$this->wip[] = $newWip;
//		$i++;
	}
	
	public function cancelWIPItem(Rakuun_Intern_Production_WIP $wipItem) {
		DB_Connection::get()->beginTransaction();
		$this->getProductionTarget()->ressources->raise($wipItem->getWIPItem()->getIronRepayForAmount(), $wipItem->getWIPItem()->getBerylliumRepayForAmount(), $wipItem->getWIPItem()->getEnergyRepayForAmount(), $wipItem->getWIPItem()->getPeopleRepayForAmount());
		$options = $this->getWIPItemsOptions();
		$options['conditions'][] = array('position > ?', $wipItem->getRecord()->position);
		foreach ($this->getItemWIPContainer()->select($options) as $wipRecord) {
			$wipRecord->starttime = time();
			$wipRecord->save();
		}
		$wipItem->getRecord()->delete();
		DB_Connection::get()->commit();
	}
}

?>