<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

abstract class Rakuun_Intern_GUI_Panel_Tutor_Level {
	private $last = null;
	private $next = null;
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	/**
	 * check if level's requirements are fulfilled
	 * @return boolean
	 */
	public abstract function completed();
	
	/**
	 * get description text
	 * @return string
	 */
	public abstract function getDescription();
	
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
		return get_class($this);
	}
}
?>