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
		
		$lastSender = '';
		if (isset($this->ticket->supporter))
			$lastSender = ' von '.$this->ticket->supporter->nameUncolored;
		elseif (isset($this->ticket->user))
			$lastSender = ' von '.$this->ticket->user->nameUncolored;
		$replyText = $this->ticket ? "\n\n--- Nachricht".$lastSender.' am '.$date->getValue()." ---\n".$this->ticket->text : '';
		$this->addPanel($message = new GUI_Control_TextArea('message', $replyText, 'Nachricht'));
		$message->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('send', 'Abschicken'));
	}
	
	public function onSend() {
		if ($this->hasErrors())
			return;
			
		$ticket = new Rakuun_Intern_Support_Ticket($this->subject, $this->message, $this->categories->getKey(), true);
		if (isset($this->ticket->supporter)) {
			$ticket->setSupporter($this->ticket->supporter);
		}
		$ticket->send();
		$this->setSuccessMessage('Nachricht versendet');
	}
}

?>