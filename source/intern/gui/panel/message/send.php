<?php

/**
 * Panel for sending IGMs
 */
class Rakuun_Intern_GUI_Panel_Message_Send extends GUI_Panel {
	private $message = null;
	private $user = null;
	
	public function __construct($name, $title = '', DB_Record $message = null, Rakuun_DB_User $user = null) {
		parent::__construct($name, $title);
			
		$this->message = $message;
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/send.tpl');
		$this->addClasses('rakuun_messages_send');
		
		$this->addPanel($recipient = new Rakuun_GUI_Control_MultiUserSelect('recipients', $this->message ? $this->message->sender : $this->user , 'Empfänger'));
		$recipient->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_TextBox('subject', $this->message ? 'RE: '.Text::escapeHTML($this->message->subject) : '', 'Betreff'));
		if ($this->message) {
			$time = new GUI_Panel_Date('date', $this->message->time);
		}
		// TODO disable answering options for non-answerable messages
		$this->addPanel($newmessage = new GUI_Control_TextArea('newmessage', ($this->message && $this->message->sender) ? "\n\n--- Nachricht von ".$this->message->sender->nameUncolored.' am '.$time->getValue()." ---\n".$this->message->text : '', 'Nachricht'));
		$newmessage->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('send', 'Abschicken'));
	}
	
	public function onSend() {
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		foreach ($this->recipients->getUser() as $recipient) {
			if ($recipient->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK())
				continue;
			
			$igm = new Rakuun_Intern_IGM(
				$this->subject,
				$recipient,
				$this->newmessage
			);
			$igm->setSender(Rakuun_User_Manager::getCurrentUser());
			foreach ($this->recipients->getUser() as $copyRecipient) {
				if ($copyRecipient != $recipient)
					$igm->addAttachment(Rakuun_Intern_IGM::ATTACHMENT_TYPE_COPYRECIPIENT, $copyRecipient);
			}
			$igm->send();
		}
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Nachricht versendet');
	}
}

?>