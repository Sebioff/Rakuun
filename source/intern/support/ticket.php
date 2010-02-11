<?php

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