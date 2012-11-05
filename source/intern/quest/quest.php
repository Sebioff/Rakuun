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

abstract class Rakuun_Intern_Quest {
	const IDENTIFIER_FIRST_COMPLETE_MOMO = 0;
	const IDENTIFIER_FIRST_LABORATORY_10 = 1;
	const IDENTIFIER_FIRST_CAPTURED_DATABASE = 2;
	
	public function awardIfPossible(DB_Record $awardTo) {
		if ($this->canBeAwarded())
			$this->awardTo($awardTo);
	}
	
	protected function awardTo(DB_Record $awardTo) {
		if (!($questRecord = Rakuun_DB_Containers::getQuestsContainer()->selectByIdentifierFirst($this->getIdentifier()))) {
			$questRecord = new DB_Record();
			$questRecord->identifier = $this->getIdentifier();
		}
		$questRecord->owner = $awardTo->getPK();
		$questRecord->time = time();
		Rakuun_DB_Containers::getQuestsContainer()->save($questRecord);
		
		// add announcement to shoutbox
		$announcementRecord = new DB_Record();
		$announcementRecord->user = Rakuun_Intern_GUI_Panel_Shoutbox::ANNOUNCER_USERID;
		$announcementRecord->text = 'Quest "'.$this->getDescription().'" wurde vergeben an '.$this->getOwnerName();
		$announcementRecord->date = time();
		Rakuun_DB_Containers::getShoutboxContainer()->save($announcementRecord);
	}
	
	public function exists() {
		return (Rakuun_DB_Containers::getQuestsContainer()->countByIdentifier($this->getIdentifier()) >= 1);
	}
	
	public function isOwnedBy(DB_Record $owner) {
		$options = array();
		$options['conditions'][] = array('owner = ?', $owner);
		$options['conditions'][] = array('identifier = ?', $this->getIdentifier());
		return (Rakuun_DB_Containers::getQuestsContainer()->count($options) >= 1);
	}
	
	public function getRecord() {
		return Rakuun_DB_Containers::getQuestsContainer()->selectByIdentifierFirst($this->getIdentifier());
	}
	
	// ABSTRACT METHODS --------------------------------------------------------
	protected abstract function getIdentifier();
	protected abstract function canBeAwarded();
	public abstract function getDescription();
	public abstract function getRewardDescription();
	public abstract function getOwnerName();
}

?>