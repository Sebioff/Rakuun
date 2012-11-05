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

class Rakuun_Intern_Support_Ticket extends DB_Record {
	const TYPE_GENERAL = 1;
	const TYPE_ABUSE = 2;
	const TYPE_BUGS = 3;
	const TYPE_ACCOUNT = 4;
	const TYPE_MULTI = 5;
	const TYPE_IMPROVEMENT = 6;
	
	public function __construct($subject = '', $text = '', $type = self::TYPE_GENERAL, $readstatus = false) {
		$this->user = Rakuun_User_Manager::getCurrentUser();
		$this->subject = $subject;
		$this->text = $text;
		$this->type = $type;
		$this->time = time();
		$this->hasBeenRead = $readstatus;
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	public function send() {
		if (!isset($this->text))
			throw new Core_Exception('Text needed');

		Rakuun_DB_Containers::getSupportticketsContainer()->save($this);
	}
	
	public static function getMessageTypes() {
		return array(
			self::TYPE_GENERAL => 'Allgemeines und Fragen',
			self::TYPE_ABUSE => 'Beleidigungen',
			self::TYPE_BUGS => 'Fehler / Bugs',
			self::TYPE_ACCOUNT => 'Account',
			self::TYPE_MULTI => 'Multihunting',
			self::TYPE_IMPROVEMENT => 'Verbesserungsvorschläge'
		);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function setSupporter(Rakuun_DB_User $supporter) {
		$this->supporter = $supporter;
	}
	
	public function setUser(Rakuun_DB_User $user) {
		$this->user = $user;
	}
	
	/**
	 * set the status of a supportticket
	 * @param status: true, if ticket is answered, otherwise false.
	 */
	public function setStatus($status = false) {
		$this->is_answered = $status;
	}
}

?>