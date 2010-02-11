<?php

abstract class Rakuun_Intern_GUI_Panel_Tutor_Level {
	protected $internal = __CLASS__;
	private $last = null;
	private $next = null;
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	/**
	 * check if level's requirements are fulfilled
	 * @return bool
	 */
	public function completed() {
		return false;
	}
	
	/**
	 * get description text
	 * @return string
	 */
	public function getDescription() {
		return '';
	}
	
	// CUSTOM METHODS ----------------------------------------------------------	
	public function finish() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$level = Rakuun_DB_Containers::getTutorContainer()->selectByUserFirst($user);
		if (!$level)
			$level = new DB_Record();
		
		$level->user = $user;
		$level->level = $this->getNext() ? $this->getNext()->getInternal() : $this->getInternal();
		$level->date = time();
		Rakuun_DB_Containers::getTutorContainer()->save($level);
	}
	
	public function rewind() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$record = Rakuun_DB_Containers::getTutorContainer()->selectByUserFirst($user);
		if (!$record) {
			$record = new DB_Record();
			$record->user = $user;
		}
		$record->level = $this->getLast()->getInternal();
		$record->date = time();
		Rakuun_DB_Containers::getTutorContainer()->save($record);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getNext() {
		return $this->next;
	}
	
	public function setNext(Rakuun_Intern_GUI_Panel_Tutor_Level $level = null) {
		$this->next = $level;
	}
	
	public function getLast() {
		return $this->last;
	}
	
	public function setLast(Rakuun_Intern_GUI_Panel_Tutor_Level $level = null) {
		$this->last = $level;
	}
	
	public function getInternal() {
		return $this->internal;
	}
}
?>