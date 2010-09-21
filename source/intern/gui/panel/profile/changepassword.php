<?php

class Rakuun_Intern_GUI_Panel_Profile_ChangePassword extends Rakuun_GUI_Panel_Box {
	public function __construct($name) {
		parent::__construct($name);
		
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