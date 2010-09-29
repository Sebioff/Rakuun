<?php

/**
 * Panel to lock users
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_User_Lock extends GUI_Panel {
	// user to lock
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null) {
		parent::__construct($name);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/lock.tpl');

		$this->addPanel($user = new Rakuun_GUI_Control_UserSelect('lockuser', $this->user, 'User'));
		$user->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($timeban = new GUI_Control_Digitbox('timeban', 0, 'Zeit in Stunden (0=dauerhafte Sperre'));
		$this->addPanel(new GUI_Control_SubmitButton('lock', 'User sperren'));
	}
	
	public function onLock() {
		$user = $this->lockuser->getUser();
		$timeban = $this->timeban->getValue();
		
		if (Rakuun_GameSecurity::get()->isInGroup($user, Rakuun_GameSecurity::GROUP_LOCKED)) {
			$this->addError('Spieler ist bereits gesperrt');
		}
		
		if ($this->hasErrors())
			return;
		
		Rakuun_User_Manager::lock($user, $timeban);
	}
}

?>