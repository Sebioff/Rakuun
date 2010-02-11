<?php

/**
 * Panel to send a IGM to all alliance members.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Mail extends GUI_Panel {
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
		$users = Rakuun_User_Manager::getCurrentUser()->alliance->members;
		foreach ($users as $user) {
			$igm = new Rakuun_Intern_IGM($this->subject, $user);
			$igm->type = Rakuun_Intern_IGM::TYPE_ALLIANCE;
			$igm->setSender(Rakuun_User_Manager::getCurrentUser());
			$igm->setText($this->text);
			$igm->send();
		}
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Mail verschickt.');
	}
}
?>