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

/**
 * Panel displaying the "envelope" of a message -> short information
 */
abstract class Rakuun_Intern_GUI_Panel_Message_Envelope extends GUI_Panel {
	private $message = null;
	private $selectionList = null;
	
	public function __construct($name, DB_Record $message, GUI_Control_CheckBoxList $selectionList = null) {
		parent::__construct($name, '');
		
		$this->message = $message;
		$this->selectionList = $selectionList;
		$this->addClasses('rakuun_message_envelope', 'clearfix');
		if (!$this->message->hasBeenRead)
			$this->addClasses('rakuun_message_unread');
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Record
	 */
	public function getMessage() {
		return $this->message;
	}
	
	/**
	 * @return GUI_Control_CheckBoxList
	 */
	public function getSelectionList() {
		return $this->selectionList;
	}
}

?>