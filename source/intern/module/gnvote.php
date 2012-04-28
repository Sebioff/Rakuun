<?php

class Rakuun_Intern_Module_GNVote extends Rakuun_Intern_Module {
	const GN_VOTE_URL = 'http://de.mmofacts.com/rakuun-67#track';
	const GN_VOTE_TIMELIMIT = 86400; // 24h
	
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser();
		if (Rakuun_User_Manager::isSitting())
			$user = $user->sitter;
		if ($user->lastGnVoting < time() - self::GN_VOTE_TIMELIMIT) {
			$user->lastGnVoting = time();
			Rakuun_User_Manager::update($user);
		}
		
		Scriptlet::redirect(self::GN_VOTE_URL);
	}
}

?>