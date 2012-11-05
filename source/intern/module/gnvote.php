<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

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