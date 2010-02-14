<?php

/**
 * Panel for answering a Supportticket
 */
class Rakuun_Intern_GUI_Panel_Support_Answer extends GUI_Panel {
	private $ticket;
	
	public function __construct($name, DB_Record $ticket, $title = '') {
		parent::__construct($name, $title);
		$this->ticket = $ticket;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/answer.tpl');
		$this->addClasses('rakuun_messages_send');
		
		$this->addPanel(new GUI_Panel_Text('recipient', $this->ticket->user->name, 'Empfänger: '));
		$this->addPanel(new GUI_Panel_Text('subject', $this->ticket->subject, 'Betreff: '));
		if ($this->ticket) {
			$date = new GUI_Panel_Date('date', $this->ticket->date);
		}
		$this->addPanel($message = new GUI_Control_TextArea('message', "\n\n---letzte Nachricht am ".$date->getValue()." ---\n".$this->ticket->text, 'Nachricht'));
		$message->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('send', 'Abschicken'));
		$this->addPanel(new GUI_Control_SubmitButton('addepted', 'als bearbeitet markieren'));
	}
	
	public function onAddepted() {
		if ($this->hasErrors())
			return;
		$this->ticket->isAnswered = true;
		$this->ticket->save();
		$this->setSuccessMessage('Nachricht als erledigt markiert');
		
	}
	
	public function onSend() {
		if ($this->hasErrors()) {
			return;
		}
		$this->ticket->supporter = Rakuun_User_Manager::getCurrentUser();
		$this->ticket->isAnswered = true;
		$this->ticket->save();
		
		
		DB_Connection::get()->beginTransaction();
		$ticket = new Rakuun_Intern_Support_Ticket($this->ticket->subject, $this->message, $this->ticket->type);
		$ticket->setStatus(true);
		$ticket->setSupporter(Rakuun_User_Manager::getCurrentUser());
		$ticket->setUser($this->ticket->user);
		$ticket->send();
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Nachricht versendet');
	}
}

?>