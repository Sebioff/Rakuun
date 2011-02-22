<?php

/**
 * Class that is responsible for producing items
 */
abstract class Rakuun_Intern_Production_Producer {
	protected $wip = array();
	private $itemContainer = null;
	private $itemWIPContainer = null;
	private $productionTarget = null;
	private $foreignKeyColumn  = '';
	private $pauseOnMissingRequirements = true;

	public function __construct(DB_Container $itemContainer, DB_Container $itemWIPContainer, DB_Record $productionTarget, $foreignKeyColumn) {
		$this->itemContainer = $itemContainer;
		$this->itemWIPContainer = $itemWIPContainer;
		$this->productionTarget = $productionTarget;
		$this->foreignKeyColumn = $foreignKeyColumn;
		
		$this->fillWIPItems();

		$this->produce();
	}

	public function produce() {
		if (!$this->getWIP())
			return;

		$wipItems = $this->getWIP();
		$firstItem = array_shift($wipItems);
		
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
			// count building up
			$options = array();
			$options['conditions'][] = array($this->foreignKeyColumn.' = ?', $this->getProductionTarget());
			$this->getItemContainer()->selectFirst($options)->raise(($firstItem->getInternalName()));
			// remove from wips
			$this->getItemWIPContainer()->delete($firstItem->getRecord());
			// production finished callback
			$this->onFinishedProduction($firstItem->getWIPItem());
			//update remaining buildings to new starttime
			// FIXME not needed?!
			foreach ($wipItems as $wipItem) {
				$wipItem->getRecord()->starttime = time() + $firstItem->getRemainingTime();
				$wipItem->getRecord()->save();
				$wipItem->setStartTime($wipItem->getRecord()->starttime);
			}

			if (DB_Connection::get()->commit()) {
				// update internal wip-list with the list that got one item less
				$this->wip = $wipItems;
				$this->produce();
			}
		}
	}
	
	/**
	 * Callback that is executed whenever an item is produced.
	 */
	protected function onFinishedProduction(Rakuun_Intern_Production_Base $producedItem) {
		
	}

	protected function fillWIPItems() {
		$options = $this->getWIPItemsOptions();
		$options['order'] = 'position ASC';
		$wipItems = $this->getItemWIPContainer()->select($options);
		foreach ($wipItems as $wipItem) {
			$this->addWIPItem($wipItem);
		}
	}
	
	public function getWIPItemsOptions() {
		$options = array();
		$options['conditions'][] = array($this->foreignKeyColumn.' = ?', $this->getProductionTarget());
		return $options;
	}

	public abstract function addWIPItem(DB_Record $wipItem);
	public abstract function cancelWIPItem(Rakuun_Intern_Production_WIP $wipItem);

	// GETTERS / SETTERS -------------------------------------------------------
	public function getWIP() {
		return $this->wip;
	}

	/**
	 * @return DB_Container
	 */
	public function getItemContainer() {
		return $this->itemContainer;
	}

	/**
	 * @return DB_Container
	 */
	public function getItemWIPContainer() {
		return $this->itemWIPContainer;
	}
	
	/**
	 * @return DB_Record
	 */
	public function getProductionTarget() {
		return $this->productionTarget;
	}
	
	public function setPauseOnMissingRequirements($pauseOnMissingRequirements) {
		$this->pauseOnMissingRequirements = $pauseOnMissingRequirements;
	}
	
	public function getPauseOnMissingRequirements() {
		return $this->pauseOnMissingRequirements;
	}
}

?>