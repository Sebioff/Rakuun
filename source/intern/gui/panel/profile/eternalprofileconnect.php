<?php

class Rakuun_Intern_GUI_Panel_Profile_EternalProfileConnect extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/eternalprofileconnect.tpl');
		
		$this->addPanel($username = new GUI_Control_TextBox('username', null, 'Nickname'));
		$username->addValidator(new GUI_Validator_RangeLength(2, 25));
		$username->addValidator(new GUI_Validator_Mandatory());
		$username->addValidator(new Rakuun_GUI_Validator_Name());
		$this->addPanel($password = new GUI_Control_PasswordBox('password', null, 'Passwort'));
		$password->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('connect', 'Speichern'));
	}

	public function onConnect() {
		$eternalUser = Rakuun_DB_Containers_Persistent::getEternalUserContainer()->selectByNameFirst($this->username);
		
		if (!$eternalUser) {
			$this->addError('Falsche Zugangsdaten');
			return;
		}
			
		$checkPWUser = new Rakuun_DB_User();
		$checkPWUser->password = $eternalUser->password;
		$checkPWUser->salt = $eternalUser->salt;
		if (!Rakuun_User_Manager::checkPassword($checkPWUser, $this->password))
			$this->addError('Falsche Zugangsdaten');
		
		if ($this->hasErrors())
			return;
			
		$record = new DB_Record();
		$record->eternalUser = $eternalUser;
		$record->user = Rakuun_User_Manager::getCurrentUser();
		Rakuun_DB_Containers::getUserEternalUserAssocContainer()->save($record);
			
		$this->getModule()->invalidate();
	}
}

?>