<?php
/**
 * Panel to send a IGM to all meta members.
 */
class Rakuun_Intern_GUI_Panel_Meta_Mail extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/mail.tpl');
		$this->addPanel($subject = new GUI_Control_TextBox('subject'));
		$subject->addValidator(new GUI_Validator_Mandatory());
		$subject->setTitle('Betreff');
		$this->addPanel($text = new GUI_Control_TextArea('text'));
		$text->addValidator(new GUI_Validator_Mandatory());
		$text->setTitle('Nachricht');
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Abschicken'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
			
		DB_Connection::get()->beginTransaction();
		$users = Rakuun_User_Manager::getCurrentUser()->alliance->meta->members;
		foreach ($users as $user) {
			$igm = new Rakuun_Intern_IGM($this->subject, $user);
			$igm->type = Rakuun_Intern_IGM::TYPE_META;
			$igm->setSender(Rakuun_User_Manager::getCurrentUser());
			$igm->setText($this->text);
			$igm->send();
			
			$attachmentRecord = new DB_Record();
			$attachmentRecord->message = $igm;
			$attachmentRecord->type = Rakuun_Intern_IGM::ATTACHMENT_TYPE_CONVERSATION;
			$attachmentRecord->value = $igm;
			Rakuun_DB_Containers::getMessagesAttachmentsContainer()->save($attachmentRecord);
		}
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Nachricht verschickt!');
	}
}
?>