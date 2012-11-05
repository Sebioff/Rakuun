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