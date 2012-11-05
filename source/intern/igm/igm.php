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

class Rakuun_Intern_IGM extends DB_Record {
	const TYPE_PRIVATE = 1;
	const TYPE_ALLIANCE = 2;
	const TYPE_META = 3;
	const TYPE_TRADE = 4;
	const TYPE_FIGHT = 5;
	const TYPE_SPY = 6;
	
	const SENDER_ALLIANCE = 'Allianz';
	const SENDER_META = 'Meta';
	const SENDER_SYSTEM = 'System';
	const SENDER_FIGHTS = 'Spionagezentrum';
	
	const ATTACHMENT_TYPE_COPYRECIPIENT = 1;
	const ATTACHMENT_TYPE_SPYREPORTLOG = 2;
	const ATTACHMENT_TYPE_FIGHTREPORTMARKERS = 3;
	const ATTACHMENT_TYPE_REPLYTO = 4;
	const ATTACHMENT_TYPE_CONVERSATION = 5;
	
	const ATTACHMENT_FIGHTREPORTMARKER_LOST = 'lost';
	const ATTACHMENT_FIGHTREPORTMARKER_WON = 'won';
	const ATTACHMENT_FIGHTREPORTMARKER_LOSTUNITS = 'lostunits';
	const ATTACHMENT_FIGHTREPORTMARKER_LOSTBUILDINGS = 'lostbuildings';
	
	private $attachments = array();
	
	public function __construct($subject = '', Rakuun_DB_User $recipient = null, $text = '', $type = self::TYPE_PRIVATE) {
		$this->subject = $subject;
		$this->text = $text;
		$this->user = $recipient;
		$this->type = $type;
		$this->time = time();
	}
	
	// CUSTOM METHODS ----------------------------------------------------------
	public function send() {
		if (!isset($this->user))
			throw new Core_Exception('Receipient needed');
			
		if (!isset($this->text))
			throw new Core_Exception('Text needed');
			
		if (!isset($this->sender) && !isset($this->senderName))
			$this->setSender(Rakuun_User_Manager::getCurrentUser());
			
		if (!isset($this->senderName))
			$this->senderName = $this->sender->nameUncolored;
			
		Rakuun_DB_Containers::getMessagesContainer()->save($this);
		
		$newConversation = true;
		foreach ($this->attachments as $attachment) {
			$attachmentRecord = new DB_Record();
			$attachmentRecord->message = $this;
			$attachmentRecord->type = $attachment[0];
			if ($attachmentRecord->type == self::ATTACHMENT_TYPE_CONVERSATION)
				$newConversation = false;
			$attachmentRecord->value = $attachment[1];
			Rakuun_DB_Containers::getMessagesAttachmentsContainer()->save($attachmentRecord);
		}
		
		if ($newConversation) {
			$attachmentRecord = new DB_Record();
			$attachmentRecord->message = $this;
			$attachmentRecord->type = Rakuun_Intern_IGM::ATTACHMENT_TYPE_CONVERSATION;
			$attachmentRecord->value = $this;
			Rakuun_DB_Containers::getMessagesAttachmentsContainer()->save($attachmentRecord);
		}
	}
	
	public static function getMessageTypes() {
		return array(
			self::TYPE_PRIVATE => 'Privat',
			self::TYPE_ALLIANCE => 'Allianz',
			self::TYPE_META => 'Meta',
			self::TYPE_TRADE => 'Handel',
			self::TYPE_FIGHT => 'Kampf',
			self::TYPE_SPY => 'Spionage'
		);
	}
	
	/**
	 * Adds a new attachment to this IGM.
	 * NOTE: the attachment won't be saved if it is added after sending the IGM
	 */
	public function addAttachment($type, $value) {
		$this->attachments[] = array($type, $value);
	}
	
	/**
	 * Returns all attachments associated with this IGM.
	 */
	public function getAttachments() {
		return Rakuun_DB_Containers::getMessagesAttachmentsContainer()->selectByMessage($this->getPK());
	}
	
	/**
	 * Returns all attachments of the given type associated with this IGM.
	 */
	public function getAttachmentsOfType($type) {
		$options = array();
		$options['conditions'][] = array('message = ?', $this->getPK());
		$options['conditions'][] = array('type = ?', $type);
		return Rakuun_DB_Containers::getMessagesAttachmentsContainer()->select($options);
	}
	
	public function canBeRepliedTo() {
		return (($this->type == self::TYPE_PRIVATE || $this->type == self::TYPE_ALLIANCE || $this->type == self::TYPE_META)
			&& ($this->sender && $this->sender->getPK() != Rakuun_User_Manager::getCurrentUser()->getPK()));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public static function getReservedNames() {
		$reflection = new ReflectionClass(__CLASS__);
		$constants = $reflection->getConstants();
		$names = array();
		foreach ($constants as $key => $constant) {
			if (strpos($key, 'SENDER_') === 0) {
				$names[] = Text::toUpperCase($constant);
			}
		}
		return $names;
	}
	
	public function setSender(Rakuun_DB_User $sender) {
		$this->sender = $sender;
	}
	
	public function setText($text) {
		$this->text = $text;
	}
	
	/**
	 * NOTICE: only use if the sender is not an actual player
	 */
	public function setSenderName($senderName) {
		$this->senderName = $senderName;
	}
	
	public function getSenderName() {
		if (isset($this->sender->name))
			return $this->sender->name;
		else
			return $this->senderName;
	}
	
	public static function getDescriptionForFightReportMarker($marker) {
		switch ($marker) {
			case self::ATTACHMENT_FIGHTREPORTMARKER_LOST:
				return 'Kampf verloren';
			case self::ATTACHMENT_FIGHTREPORTMARKER_WON:
				return 'Kampf gewonnen';
			case self::ATTACHMENT_FIGHTREPORTMARKER_LOSTUNITS:
				return 'Einheiten verloren';
			case self::ATTACHMENT_FIGHTREPORTMARKER_LOSTBUILDINGS:
				return 'Gebäude verloren';
			default:
				return '';
		}
	}
}

?>