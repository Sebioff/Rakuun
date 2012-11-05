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

class Rakuun_Index_Panel_PasswordForgotten extends GUI_Panel {
	const PASSWORD_LENGTH = 7; // length of the new random password
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/passwordforgotten.tpl');
		
		$this->addPanel($username = new GUI_Control_TextBox('username', null, 'Nickname'));
		$username->addValidator(new GUI_Validator_Mandatory());
		$username->setFocus();
		$this->addPanel($mail = new GUI_Control_TextBox('mail', null, 'E-Mail'));
		$mail->addValidator(new GUI_Validator_Mandatory());
		$mail->addValidator(new GUI_Validator_Mail());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Passwort anfordern'));
	}
	
	public function onSubmit() {
		$user = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($this->username);
		
		if (!$user)
			$this->addError('Username existiert nicht');
		elseif ($user->mail != $this->mail->getValue())
			$this->addError('Username und Mailadresse stimmen nicht überein!');
			
		if ($this->hasErrors())
			return;
		
		// new random password
		$password = $this->createRandomPassword();
		$user->password = Rakuun_User_Manager::cryptPassword($password, $user->salt);

		// notify the user about his new password
		if ($user->mail) {
			$mail = new Net_Mail();
			$mail->setSubject('Rakuun: neues Passwort!');
			$mail->addRecipients($user->nameUncolored.' <'.$user->mail.'>');
			$templateEngine = new GUI_TemplateEngine();
			$templateEngine->username = $user->nameUncolored;
			$templateEngine->password = $password;

			$mail->setMessage($templateEngine->render(dirname(__FILE__).'/password_forgotten_mail.tpl'));
			$mail->send();
		}
		
		// logging and updating...
		Rakuun_Intern_Log_Userdata::log($user, Rakuun_Intern_Log::ACTION_USERDATA_PASSWORD, $user->password);
		Rakuun_User_Manager::update($user);
		$this->setSuccessMessage('Neues Passwort gespeichert');
	}

	/**
	 * Creates a new random password.
	 *
	 * The letter l (lowercase L) and the number 1
	 * have been removed, as they can be mistaken
	 * for each other.
	 */
	private function createRandomPassword() {
	    $chars = 'abcdefghijkmnopqrstuvwxyz023456789';
	    srand((double)microtime()*1000000);
	    $i = 0;
	    $pass = '' ;
	
	    while ($i <= self::PASSWORD_LENGTH) {
	        $num = rand() % 33;
	        $tmp = substr($chars, $num, 1);
	        $pass .= $tmp;
	        $i++;
	    }
	    
	    return $pass;
	}
}

?>