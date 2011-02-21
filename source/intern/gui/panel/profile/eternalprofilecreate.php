<?php

class Rakuun_Intern_GUI_Panel_Profile_EternalProfileCreate extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/eternalprofilecreate.tpl');
		
		$this->addPanel($username = new GUI_Control_TextBox('username', null, 'Nickname'));
		$username->addValidator(new GUI_Validator_RangeLength(2, 25));
		$username->addValidator(new GUI_Validator_Mandatory());
		$username->addValidator(new Rakuun_GUI_Validator_Name());
		$this->addPanel($password = new GUI_Control_PasswordBox('password', null, 'Passwort'));
		$password->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($password_repeat = new GUI_Control_PasswordBox('password_repeat', null, 'Passwort (Wiederholung)'));
		$password_repeat->addValidator(new GUI_Validator_Mandatory());
		$password_repeat->addValidator(new GUI_Validator_Equals($password));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Speichern'));
	}
	
	public function onSubmit() {
		if (Rakuun_DB_Containers_Persistent::getEternalUserContainer()->selectByNameFirst($this->username))
			$this->addError('Ein Profil mit diesem Namen existiert bereits');
			
		if ($this->hasErrors())
			return;
			
		$eternalUser = new DB_Record();
		$eternalUser->name = $this->username;
		$eternalUser->salt = md5(time() / rand());
		$eternalUser->password = Rakuun_User_Manager::cryptPassword($this->password->getValue(), $eternalUser->salt);
		Rakuun_DB_Containers_Persistent::getEternalUserContainer()->save($eternalUser);
		
		$record = new DB_Record();
		$record->eternalUser = $eternalUser;
		$record->user = Rakuun_User_Manager::getCurrentUser();
		Rakuun_DB_Containers::getUserEternalUserAssocContainer()->save($record);
		
		$this->getModule()->invalidate();
	}
}

?>