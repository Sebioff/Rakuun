<?php

class Rakuun_Intern_GUI_Panel_Admin_User_Edit extends GUI_Panel {

	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null) {
		parent::__construct($name);
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/edit.tpl');
		
		if (!$this->user)
			return;
		
		$this->addPanel($username = new GUI_Control_TextBox('username', $this->user->nameUncolored, 'Nickname'));
		$username->addValidator(new GUI_Validator_RangeLength(2, 25));
		$username->addValidator(new GUI_Validator_Mandatory());
		$username->addValidator(new Rakuun_GUI_Validator_Name());
		$this->addPanel($cityname = new GUI_Control_TextBox('cityname', $this->user->cityName, 'Stadtname'));
		$cityname->addValidator(new GUI_Validator_Mandatory());
		$cityname->addValidator(new GUI_Validator_MaxLength(20));
		
		// FIXME create a privilege for this
		if (Rakuun_GameSecurity::get()->isInGroup($this->user, Rakuun_GameSecurity::GROUP_SPONSORS)) {
			$this->addPanel($description = new GUI_Control_Textarea('description', $this->user->description, 'Beschreibung'));
			$description->addValidator(new GUI_Validator_HTML());
			$description->addValidator(new GUI_Validator_MaxLength(5000));
		}

		$this->addPanel($skinselect = new GUI_Control_DropDownBox('skin', Rakuun_GUI_Skinmanager::get()->getAllSkins(), Rakuun_GUI_Skinmanager::get()->getCurrentSkin()->getNameID(), 'Skin'));
		$this->addPanel($mail = new GUI_Control_TextBox('mail', $this->user->mail, 'EMail-Adresse'));
		$mail->addValidator(new GUI_Validator_Mandatory());
		$mail->addValidator(new GUI_Validator_Mail());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Speichern'));
		
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
		
		if ($this->user->nameUncolored != $this->username->getValue()) {
			$this->user->name = $this->username;
			$this->user->nameColored = '';
		}
		$this->user->cityName = $this->cityname;
		if ($this->hasPanel('description'))
			$this->user->description = $this->description;
		$this->user->mail = $this->mail;
		$this->user->skin = $this->skin->getKey();
		Rakuun_User_Manager::update($this->user);
		Rakuun_GUI_Skinmanager::get()->setCurrentSkin($this->user->skin);
	}
	
	public function getUser() {
		return $this->user;
	}
}

?>