<?php

/**
 * Displays a single IGM
 */
class Rakuun_Intern_GUI_Panel_Message extends GUI_Panel {
	private $message = null;
	
	public function __construct($name, DB_Record $message) {
		parent::__construct($name, '');
		
		$this->message = $message;
		$this->addClasses('rakuun_message');
	}
	
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser()->getPK();
		if ($this->message->user->getPK() != $user && (!$this->message->sender || $this->message->sender->getPK() != $user))
			return;
		
		if (!$this->message->hasBeenRead && $this->message->sender->getPK() != $user) {
			$this->message->hasBeenRead = true;
			$this->message->save();
		}
		
		$this->setTemplate(dirname(__FILE__).'/message.tpl');
		$this->addPanel(new GUI_Panel_Date('date', $this->message->time, 'Datum'));
		if (isset($this->message->sender->name))
			$this->addPanel(new Rakuun_GUI_Control_UserLink('sender', $this->message->sender, 'Sender'));
		else
			$this->addPanel(new GUI_Panel_Text('sender', $this->message->getSenderName(), 'Sender'));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Record
	 */
	public function getMessage() {
		return $this->message;
	}
}

?>