<?php

class Rakuun_Intern_Module_GNVote extends Module {
	const GN_VOTE_URL = 'http://www.galaxy-news.de/?page=charts&op=vote&game_id=67';
	const GN_VOTE_TIMELIMIT = 86400; // 24h
	
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser();
		if ($user->lastGnVoting < time() - self::GN_VOTE_TIMELIMIT) {
			$user->lastGnVoting = time();
			Rakuun_User_Manager::update($user);
		}
		
		Scriptlet::redirect(self::GN_VOTE_URL);
	}
}

?>