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

class Rakuun_Intern_GUI_Panel_User_Sitterbox extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/sitterbox.tpl');
		
		if (Rakuun_User_Manager::isSitting()) {
			$otherUser = Rakuun_User_Manager::getCurrentUser();
			$noteLabel = 'Nachricht an den Sittling';
		}
		else {
			$otherUser = Rakuun_User_Manager::getCurrentUser()->sitter;
			$noteLabel = 'Nachricht an den Sitter';
		}
		$this->addPanel($userLink = new Rakuun_GUI_Control_UserLink('sittername', $otherUser));
		$this->addPanel($noteTextArea = new GUI_Control_TextArea('note', Rakuun_User_Manager::getCurrentUser()->sitterNote, $noteLabel));
		$noteTextArea->setAttribute('rows', 8);
		$this->addPanel($submitButton = new GUI_Control_SubmitButton('submit', 'Speichern'));
		$submitButton->addClasses('no_margin');
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
			
		$user = Rakuun_User_Manager::getCurrentUser();
		$user->sitterNote = $this->note;
		Rakuun_User_Manager::update($user);
	}
}

?>