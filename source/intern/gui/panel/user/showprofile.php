<?php

/**
 * Show the public Profile of a User
 * @author dr.dent
 *
 */
class Rakuun_Intern_GUI_Panel_User_ShowProfile extends GUI_Panel {
	/* User to show the Profile of */
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null) {
		parent::__construct($name, 'Profil anzeigen');
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/showprofile.tpl');
				
		if ($this->user && $this->user->picture)
			$this->addPanel(new GUI_Panel_UploadedFile('picture', $this->user->picture, 'Profilbild von '.$this->user->nameUncolored));

	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getUser() {
		return $this->user;
	}
}

?>