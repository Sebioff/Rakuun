<?php

class Rakuun_Intern_GUI_Panel_User_Adminnews extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/adminnews.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();
		
		$this->addPanel($adminnews = new GUI_Panel_Text('adminnews', $user->adminnews ,'Nachricht von den Admins'));
	}
}

?>