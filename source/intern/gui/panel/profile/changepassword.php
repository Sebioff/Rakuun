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

class Rakuun_Intern_GUI_Panel_Profile_ChangePassword extends Rakuun_GUI_Panel_Box {
	public function __construct($name, $title = '') {
		parent::__construct($name, null, $title);
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->contentPanel->setTemplate(dirname(__FILE__).'/changepassword.tpl');
		$this->contentPanel->addPanel($oldPassword = new GUI_Control_PasswordBox('old_password', null, 'Altes Passwort'));
		$oldPassword->addValidator(new GUI_Validator_Mandatory());
		$this->contentPanel->addPanel($password = new GUI_Control_PasswordBox('password', null, 'Neues Passwort'));
		$password->addValidator(new GUI_Validator_Mandatory());
		$this->contentPanel->addPanel($passwordRepeat = new GUI_Control_PasswordBox('password_repeat', null, 'Neues Passwort (Wiederholung)'));
		$passwordRepeat->addValidator(new GUI_Validator_Mandatory());
		$passwordRepeat->addValidator(new GUI_Validator_Equals($password));
		$this->contentPanel->addPanel(new GUI_Control_SubmitButton('submit', 'Speichern'));
	}
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$oldPassword = Rakuun_User_Manager::cryptPassword($this->contentPanel->oldPassword->getValue(), $user->salt);
		if ($oldPassword != $user->password)
			$this->contentPanel->addError('Falsches Passwort', $this->contentPanel->oldPassword);
		
		if ($this->contentPanel->hasErrors())
			return;
		
		$user->password = Rakuun_User_Manager::cryptPassword($this->contentPanel->password->getValue(), $user->salt);
		Rakuun_Intern_Log_Userdata::log($user, Rakuun_Intern_Log::ACTION_USERDATA_PASSWORD, $user->password);
		Rakuun_User_Manager::update($user);
		$this->contentPanel->setSuccessMessage('Neues Passwort gespeichert');
	}
}

?>