<?php

/**
 * Panel for sending IGMs
 */
class Rakuun_Intern_GUI_Panel_Message_Send extends GUI_Panel {
	private $replyToMessage = null;
	private $sendToUsers = array();
	
	public function __construct($name, $title = '', DB_Record $replyToMessage = null, array $sendToUsers = array()) {
		parent::__construct($name, $title);
			
		$this->replyToMessage = $replyToMessage;
		$this->sendToUsers = $sendToUsers;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/send.tpl');
		$this->addClasses('rakuun_messages_send');
		
		$this->addPanel($recipients = new Rakuun_GUI_Control_MultiUserSelect('recipients', null, 'Empfänger'));
		$recipients->addValidator(new GUI_Validator_Mandatory());
		$recipientNames = array();
		foreach ($this->sendToUsers as $user)
			$recipientNames[] = $user->nameUncolored;
		$recipients->setValue(implode(', ', $recipientNames));
		$this->addPanel(new GUI_Control_TextBox('subject', $this->replyToMessage ? 'RE: '.Text::escapeHTML($this->replyToMessage->subject) : '', 'Betreff'));
		if ($this->replyToMessage) {
			$time = new GUI_Panel_Date('date', $this->replyToMessage->time);
		}
		$this->addPanel($newmessage = new GUI_Control_TextArea('newmessage', ($this->replyToMessage && $this->replyToMessage->sender) ? "\n\n--- Nachricht von ".$this->replyToMessage->sender->nameUncolored.' am '.$time->getValue()." ---\n".$this->replyToMessage->text : '', 'Nachricht'));
		$newmessage->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_CheckBox('blindcopies', '', false, 'Blindkopien'));
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
			if (!$this->blindcopies->getSelected()) {
				foreach ($this->recipients->getUser() as $copyRecipient) {
					if ($copyRecipient->getPK() != $recipient->getPK())
						$igm->addAttachment(Rakuun_Intern_IGM::ATTACHMENT_TYPE_COPYRECIPIENT, $copyRecipient);
				}
			}
			$igm->send();
		}
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Nachricht versendet');
	}
}

?>