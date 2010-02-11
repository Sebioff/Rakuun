<?php

/**
 * Sends an ingamemessage to all users
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_Mail extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/mail.tpl');
		
		$this->addPanel(new GUI_Control_TextBox('subject', '', 'Betreff'));
		$this->addPanel($message = new GUI_Control_TextArea('message', '', 'Nachricht'));
		$message->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('send', 'Abschicken'));
	}
	
	public function onSend() {
		if ($this->hasErrors())
			return;
			
		foreach (Rakuun_DB_Containers::getUserContainer()->select() as $user) {
			$igm = new Rakuun_Intern_IGM($this->subject, $user, $this->message);
			$igm->setSenderName(Rakuun_Intern_IGM::SENDER_SYSTEM);
			$igm->send();
		}
		$this->setSuccessMessage('Nachricht versendet');
	}
}

?>