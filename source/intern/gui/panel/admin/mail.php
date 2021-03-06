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