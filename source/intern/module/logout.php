<?php

class Rakuun_Intern_Module_Logout extends Module {
	public function init() {
		parent::init();
		
		Rakuun_User_Manager::logout();
		Scriptlet::redirect(App::get()->getIndexModule()->getUrl());
	}
}

?>