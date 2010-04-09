<?php

class Rakuun_Intern_GUI_Panel_User_SitterSwitch extends GUI_Panel {
	private $sitting = null;
	
	public function __construct($name, Rakuun_DB_User $sitting) {
		parent::__construct($name);
		
		$this->sitting = $sitting;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/sitterswitch.tpl');
		
		$this->addPanel(new Rakuun_GUI_Control_UserLink('sittingname', $this->getSitting()));
		$this->addPanel(new GUI_Control_SubmitButton('switch', 'Wechseln'));
		$this->addPanel(new GUI_Control_SubmitButton('delete', 'Löschen'));
	}
	
	public function onDelete() {
		if ($this->hasErrors())
			return;

		$this->getSitting()->sitter = null;
		$this->getSitting()->save();
	}
	
	public function onSwitch() {
		if ($this->hasErrors())
			return;
		
		$originalUser = Rakuun_User_Manager::getCurrentUser();
		$_SESSION['userOriginal'] = $originalUser->getPK();
		$_SESSION['user'] = $this->getSitting()->getPK();
		$_SESSION['isSitting'] = true;
		$user = Rakuun_User_Manager::getCurrentUser();
		$user->lastActivity = time();
		if ($originalUser->lastBotVerification > $user->lastBotVerification)
			$user->lastBotVerification = $originalUser->lastBotVerification;
		Rakuun_User_Manager::update($user);
		$this->getModule()->invalidate();
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_DB_User
	 */
	public function getSitting() {
		return $this->sitting;
	}
}

?>