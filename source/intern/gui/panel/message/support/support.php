<?php

/**
 * Panel for sending messages to the support
 */
class Rakuun_Intern_GUI_Panel_Message_Support extends GUI_Panel {
	private $ticket = null;
	
	public function __construct($name, $title = '', DB_Record $ticket = null) {
		parent::__construct($name, $title);
		
		$this->ticket = $ticket;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/support.tpl');
		$this->addClasses('rakuun_messages_send');
		
		
		$categories = Rakuun_Intern_Support_Ticket::getMessageTypes();
		$this->addPanel($category = new GUI_Control_DropDownBox('categories', $categories, $this->ticket ? $categories[$this->ticket->type] : $categories[1], 'Kategorie'));
		$this->addPanel(new GUI_Control_TextBox('subject', $this->ticket ? $this->ticket->subject : '', 'Betreff'));
		if ($this->ticket) {
			$date = new GUI_Panel_Date('date', $this->ticket->date);
		}
		$this->addPanel($message = new GUI_Control_TextArea('message', $this->ticket ? "\n\n--- letzte Nachricht von ".$this->ticket->supporter->nameUncolored.' am '.$date->getValue()." ---\n".$this->ticket->text : '', 'Nachricht'));
		$message->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('send', 'Abschicken'));
	}
	
	public function onSend() {
		if ($this->hasErrors())
			return;
			
		$ticket = new Rakuun_Intern_Support_Ticket($this->subject, $this->message, $this->categories->getKey(), true);
		if ($this->ticket) {
			$ticket->setSupporter($this->ticket->supporter);
		}
		$ticket->send();
		$this->setSuccessMessage('Nachricht versendet');
	}
}

?>