<?php

class Rakuun_Intern_GUI_Panel_Profile_EternalProfileManage extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/eternalprofilemanage.tpl');
		
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Profile_EternalProfileCreate('create'));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Profile_EternalProfileConnect('connect'));
	}

	public function onConnect() {
		$eternalUser = Rakuun_DB_Containers_Persistent::getEternalUserContainer()->selectByNameFirst($this->username);
		
		if (!$eternalUser)
			$this->addError('Falsche Zugangsdaten');
			
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