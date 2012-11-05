<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

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
		
		if ($this->ticket->user) {
			$this->addPanel(new GUI_Panel_Text('recipient', $this->ticket->user->name, 'Empfänger: '));
			$this->addPanel(new GUI_Panel_Text('subject', $this->ticket->subject, 'Betreff: '));
			if ($this->ticket) {
				$date = new GUI_Panel_Date('date', $this->ticket->date);
			}
			$this->addPanel($message = new GUI_Control_TextArea('message', "\n\n--- Nachricht von ".$this->ticket->user->nameUncolored.' am '.$date->getValue()." ---\n".$this->ticket->text, 'Nachricht'));
			$message->addValidator(new GUI_Validator_Mandatory());
			$this->addPanel(new GUI_Control_SubmitButton('send', 'Abschicken'));
		}
		$this->params->user = $this->ticket->user;
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