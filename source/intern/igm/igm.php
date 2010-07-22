<?php

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
		
		foreach ($this->attachments as $attachment) {
			$attachmentRecord = new DB_Record();
			$attachmentRecord->message = $this;
			$attachmentRecord->type = $attachment[0];
			$attachmentRecord->value = $attachment[1];
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
	
	public function addAttachment($type, $value) {
		$this->attachments[] = array($type, $value);
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
}

?>