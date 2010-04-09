<?php

class Rakuun_Intern_Module_LogoutSitter extends Module {
	public function init() {
		parent::init();
		
		$originalUser = Rakuun_User_Manager::getCurrentUser();
		$_SESSION['user'] = $_SESSION['userOriginal'];
		$_SESSION['isSitting'] = false;
		unset($_SESSION['userOriginal']);
		$user = Rakuun_User_Manager::getCurrentUser();
		$user->lastActivity = time();
		if ($originalUser->lastBotVerification > $user->lastBotVerification)
			$user->lastBotVerification = $originalUser->lastBotVerification;
		Rakuun_User_Manager::update($user);
		Scriptlet::redirect(App::get()->getInternModule()->getSubmodule('overview')->getUrl());
	}
}

?>