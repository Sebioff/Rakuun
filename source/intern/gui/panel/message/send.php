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
		if ($this->sendToUsers) {
			foreach ($this->sendToUsers as $user)
				$recipientNames[] = $user->nameUncolored;
			$recipientNames = array_merge($recipientNames, explode(', ', $recipients->getValue()));
			$recipients->setValue(implode(', ', $recipientNames));
		}
		$subjectDefaultValue = '';
		if ($this->replyToMessage) {
			$subjectDefaultValue = Text::escapeHTML($this->replyToMessage->subject);
			if (strpos($subjectDefaultValue, 'RE(') === 0) {
				$reCount = 0;
				preg_match('/RE\((.*?)\)/', $subjectDefaultValue, $reCount);
				$reCount = ++$reCount[1];
				$subjectDefaultValue = preg_replace('/RE\((\d*?)\)/', 'RE('.$reCount.')', $subjectDefaultValue);
			}
			else
				$subjectDefaultValue = 'RE(1): '.$subjectDefaultValue;
		}
		$this->addPanel(new GUI_Control_TextBox('subject', $subjectDefaultValue, 'Betreff'));
		$this->addPanel($newmessage = new GUI_Control_TextArea('newmessage', '', 'Nachricht'));
		$newmessage->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($infoPanel = new Rakuun_GUI_Panel_Info('blindcopy', 'Blindkopien', 'Empfänger können nicht sehen, an wen die Nachricht sonst geschickt wurde.'));
		$this->addPanel($blindCopiesCheckbox = new GUI_Control_CheckBox('blindcopies', '', false, $infoPanel));
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
			
			$newConversation = false;
			if ($this->replyToMessage) {
				$igm->addAttachment(Rakuun_Intern_IGM::ATTACHMENT_TYPE_REPLYTO, $this->replyToMessage->getPK());
				$conversationAttachments = $this->replyToMessage->getAttachmentsOfType(Rakuun_Intern_IGM::ATTACHMENT_TYPE_CONVERSATION);
				$igm->addAttachment(Rakuun_Intern_IGM::ATTACHMENT_TYPE_CONVERSATION, $conversationAttachments[0]->value);
			}
			else
				$newConversation = true;
				
			$igm->send();
			if ($newConversation) {
				$attachmentRecord = new DB_Record();
				$attachmentRecord->message = $igm;
				$attachmentRecord->type = Rakuun_Intern_IGM::ATTACHMENT_TYPE_CONVERSATION;
				$attachmentRecord->value = $igm;
				Rakuun_DB_Containers::getMessagesAttachmentsContainer()->save($attachmentRecord);
			}
		}
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Nachricht versendet');
	}
}

?>