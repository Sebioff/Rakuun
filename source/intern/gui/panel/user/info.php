<?php

class Rakuun_Intern_GUI_Panel_User_Info extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/info.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();	
		if ($user)
			$this->addPanel(new GUI_Panel_UploadedFile('picture', $user->picture, 'Profilbild von '.$user->nameUncolored));

	}
}

?>