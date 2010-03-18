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
		
		$userPK = Rakuun_User_Manager::getCurrentUser()->getPK();
		if ($this->message->user->getPK() != $userPK && (!$this->message->sender || $this->message->sender->getPK() != $userPK))
			return;
		
		if (!$this->message->hasBeenRead && $this->message->user->getPK() == $userPK) {
			$this->message->hasBeenRead = true;
			$this->message->save();
		}
		
		$this->setTemplate(dirname(__FILE__).'/message.tpl');
		$this->addPanel(new GUI_Panel_Date('date', $this->message->time, 'Datum'));
		if (isset($this->message->sender->name))
			$this->addPanel(new Rakuun_GUI_Control_UserLink('sender', $this->message->sender, 'Sender'));
		else
			$this->addPanel(new GUI_Panel_Text('sender', $this->message->getSenderName(), 'Sender'));
		if ($this->message->user->getPK() == $userPK)
			$this->addPanel(new GUI_Control_Submitbutton('delete', 'Löschen'));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Record
	 */
	public function getMessage() {
		return $this->message;
	}
	
	public function onDelete() {
		Rakuun_DB_Containers::getMessagesContainer()->delete($this->message);
		$this->getModule()->redirect(App::get()->getInternModule()->getSubmodule('messages')->getUrl());
	}
}

?>