<?php

class Rakuun_Index_Panel_PasswordForgotten extends GUI_Panel {
	const PASSWORD_LENGTH = 7; //Length of the new random password
	
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
			if ($user->mail != $this->mail->getValue())
				$this->addError('Username und Mailadresse stimmen nicht überein!');
			
		if ($this->hasErrors())
			return;
		
		//new random password
		$password = self::createRandomPassword();
		$user->password = Rakuun_User_Manager::cryptPassword($password, $user->salt);

		//notify the user about his new password
		if ($user->mail) {
			try {
				$mail = new Net_Mail();
				$mail->setSubject('Rakuun: neues Passwort!');
				$mail->addRecipients($user->nameUncolored.' <'.$user->mail.'>');
				$templateEngine = new GUI_TemplateEngine();
				$templateEngine->username = $user->nameUncolored;
				$templateEngine->password = $password;

				$mail->setMessage($templateEngine->render(dirname(__FILE__).'/password_forgotten_mail.tpl'));
				$mail->send();
			}
			catch (Core_Exception $e) {
				IO_Log::get()->error($e->getTraceAsString());
			}
		}
		
		//logging and updating...
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
	private static function createRandomPassword() {
	    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
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