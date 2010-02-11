<?php

class Rakuun_Intern_Module_LogoutSitter extends Module {
	public function init() {
		parent::init();
		
		$_SESSION['user'] = $_SESSION['userOriginal'];
		$_SESSION['isSitting'] = false;
		unset($_SESSION['userOriginal']);
		Scriptlet::redirect(App::get()->getInternModule()->getSubmodule('overview')->getUrl());
	}
}

?>