<?php

class Rakuun_Intern_GUI_Panel_Profile_EternalProfile extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/eternalprofile.tpl');
		
		$options = array();
		$options['order'] = 'end_time DESC';
		$roundNames = array();
		foreach (Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->select($options) as $roundInformation)
			$roundNames[] = $roundInformation->roundName;
		
		$this->addPanel(new GUI_Control_DropDownBox('round', $roundNames, null, 'Runde'));
		$this->addPanel($username = new GUI_Control_TextBox('username', null, 'Nickname'));
		$username->addValidator(new GUI_Validator_RangeLength(2, 25));
		$username->addValidator(new GUI_Validator_Mandatory());
		$username->addValidator(new Rakuun_GUI_Validator_Name());
		$this->addPanel($password = new GUI_Control_PasswordBox('password', null, 'Passwort'));
		$password->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('add', 'Hinzufügen'));
		
		$profiles = array();
		$eternalUser = Rakuun_DB_Containers::getUserEternalUserAssocContainer()->selectByUserFirst(Rakuun_User_Manager::getCurrentUser());
		$linkedProfiles = Rakuun_DB_Containers_Persistent::getEternalUserUserAssocContainer()->selectByEternalUser($eternalUser);
		foreach ($linkedProfiles as $profileAssoc) {
			$roundInformation = Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->selectByPK($profileAssoc->round);
			$adapter = Rakuun_Intern_Achievements_AdapterFactory::get()->getAdapterForRound($roundInformation->roundName);
			$profile = $adapter->getRoundContainer('user', $roundInformation->roundName)->selectByPK($profileAssoc->user);
			$profiles[] = 'Runde '.$roundInformation->roundName.': '.$profile->name;
		}
		$this->params->linkedProfiles = $profiles;
	}
	
	public function onAdd() {
		$eternalUserAssoc = Rakuun_DB_Containers::getUserEternalUserAssocContainer()->selectByUserFirst(Rakuun_User_Manager::getCurrentUser());
		$eternalUser = Rakuun_DB_Containers_Persistent::getEternalUserContainer()->selectByPK($eternalUserAssoc->eternalUser);
		
		$adapter = Rakuun_Intern_Achievements_AdapterFactory::get()->getAdapterForRound($this->round->getValue());
		if ($error = $adapter->addUserEternalUserAssoc($this->username->getValue(), $this->password->getValue(), $this->round->getValue(), $eternalUser))
			$this->addError($error);
		
		if ($this->hasErrors())
			return;
			
		$this->getModule()->invalidate();
	}
}

?>