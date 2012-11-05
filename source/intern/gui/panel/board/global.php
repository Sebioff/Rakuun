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

class Rakuun_Intern_GUI_Panel_Board_Global extends Rakuun_Intern_GUI_Panel_Board {
	public function __construct($name, $title = '') {
		$this->config = self::getConfig();
		
		parent::__construct($name, $title);
	}
	
	public static function getConfig() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$config = new Board_Config();
		$config->setBoardsContainer(Rakuun_DB_Containers_Persistent::getBoardsGlobalContainer());
		$config->setBoardRecord(new DB_Record());
		$config->setPostingsContainer(Rakuun_DB_Containers_Persistent::getBoardsGlobalPostingsContainer());
		$posting = new DB_Record();
		$posting->userName = $user->nameUncolored;
		$posting->roundNumber = RAKUUN_ROUND_NAME;
		$config->setPostingRecord($posting);
		$config->setVisitedContainer(Rakuun_DB_Containers_Persistent::getBoardsGlobalLastVisitedContainer());
		$config->setIsGlobal(true);
		$config->setBoardModule(App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('global'));
		$config->setUserIsMod(Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_MODERATION));
		
		return $config;
	}
}

?>