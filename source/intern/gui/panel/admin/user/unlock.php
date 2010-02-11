<?php

/**
 * Panel to Unlock User
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_User_Unlock extends GUI_Panel {
	public function __construct($name, Rakuun_DB_User $user = null) {
		parent::__construct($name);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/unlock.tpl');
		
		// get only users of the group "LOCKED" into the DropDownBox
		$lockedusers = array();
		foreach (Rakuun_GameSecurity::get()->getGroupUsers(Rakuun_GameSecurity::GROUP_LOCKED) as $lockeduser)
			$lockedusers[$lockeduser->getPK()] = $lockeduser->nameUncolored;
		$this->addPanel(new GUI_Control_DropDownBox('lockedusers', $lockedusers));
		
		$this->addPanel(new GUI_Control_SubmitButton('unlock', 'User entsperren'));
	}
	
	public function onUnlock() {
		$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($this->lockedusers->getKey());
		if (!$user) {
			$this->addError('kein Spieler ausgewählt');
		}
		
		if ($this->hasErrors())
			return;
		
		Rakuun_User_Manager::unlock($user);
	}
}

?>