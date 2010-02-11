<?php

/**
 * Decorator for Rakuun_Intern_Production_Base
 */
class Rakuun_Intern_Production_WIP extends GUI_Panel {
	private $wipItem = null;
	private $startTime = 0;
	private $record = 0;
	private $itemWIPContainer = null;
	
	public function __construct($name, DB_Container $itemWIPContainer, Rakuun_Intern_Production_Base $wipItem) {
		parent::__construct($name);
		
		$this->itemWIPContainer = $itemWIPContainer;
		$this->wipItem = $wipItem;
		$this->setTemplate(dirname(__FILE__).'/wip.tpl');
		$this->addPanel(new GUI_Control_SubmitButton('move_up', '^'));
		$this->addPanel(new GUI_Control_SubmitButton('move_down', 'v'));
	}
	
	/**
	 * Moves this item up in the queue
	 */
	public function onMoveUp() {
		$options = array();
		$options['conditions'][] = array('position < ?', $this->getRecord()->position);
		$options['order'] = 'position DESC';
		$nextRecord = $this->getItemWIPContainer()->selectFirst($options);
		if ($nextRecord) {
			DB_Connection::get()->beginTransaction();
			$tempPosition = $nextRecord->position;
			$nextRecord->position = $this->getRecord()->position;
			$this->getRecord()->position = $tempPosition;
			$nextRecord->save();
			$this->getRecord()->save();
			DB_Connection::get()->commit();
			$this->getModule()->invalidate();
		}
	}
	
	/**
	 * Moves this item down in the queue
	 */
	public function onMoveDown() {
		$options = array();
		$options['conditions'][] = array('position > ?', $this->getRecord()->position);
		$options['order'] = 'position ASC';
		$nextRecord = $this->getItemWIPContainer()->selectFirst($options);
		if ($nextRecord) {
			DB_Connection::get()->beginTransaction();
			$tempPosition = $nextRecord->position;
			$nextRecord->position = $this->getRecord()->position;
			$this->getRecord()->position = $tempPosition;
			$nextRecord->save();
			$this->getRecord()->save();
			DB_Connection::get()->commit();
			$this->getModule()->invalidate();
		}
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	/**
	 * @return int the time still needed to complete this item
	 */
	public function getRemainingTime() {
		return $this->getWIPItem()->getTimeCosts() - (time() - $this->getStartTime());
	}
	
	/**
	 * @return int the timestamp at which this item will be completed
	 */
	public function getTargetTime() {
		return $this->getWIPItem()->getTimeCosts() + $this->getStartTime();
	}
	
	/**
	 * @return GUI_Panel_HoverInfo
	 */
	public function getNeededTimePanel() {
		return new GUI_Panel_HoverInfo($this->getInternalName().'_neededtime', Rakuun_Date::formatCountDown($this->getTimeCosts()), '');
	}
	
	public function __call($name, $params) {
		return call_user_func_array(array($this->getWIPItem(), $name), $params);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Record
	 */
	public function getRecord() {
		return $this->record;
	}
	
	public function setRecord($record) {
		$this->record = $record;
	}
	
	/**
	 * @return Rakuun_Intern_Production_Base
	 */
	public function getWIPItem() {
		return $this->wipItem;
	}
	
	public function getStartTime() {
		return $this->startTime;
	}
	
	public function setStartTime($startTime) {
		$this->startTime = $startTime;
	}
	
	/**
	 * @return DB_Container
	 */
	public function getItemWIPContainer() {
		return $this->itemWIPContainer;
	}
}

?>