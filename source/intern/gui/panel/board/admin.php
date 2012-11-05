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

class Rakuun_Intern_GUI_Panel_Board_Admin extends Rakuun_Intern_GUI_Panel_Board {
	public function __construct($name, $title = '') {
		$this->config = self::getConfig();
		
		parent::__construct($name, $title);
	}
	
	public static function getNewPostingsCount(DB_Container $null = null, DB_Container $anothernull = null) {
		return parent::getNewPostingsCount(
			Rakuun_DB_Containers::getBoardsAdminContainer(),
			Rakuun_DB_Containers::getBoardsAdminLastVisitedContainer()
		);
	}
	
	public static function getConfig() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$config = new Board_Config();
		$config->setBoardsContainer(Rakuun_DB_Containers::getBoardsAdminContainer());
		$config->setBoardRecord(new DB_Record);
		$config->setPostingsContainer(Rakuun_DB_Containers::getBoardsAdminPostingsContainer());
		$posting = new DB_Record();
		$posting->user = $user;
		$config->setPostingRecord($posting);
		$config->setVisitedContainer(Rakuun_DB_Containers::getBoardsAdminLastVisitedContainer());
		$config->setBoardModule(App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('admin'));
		$config->setUserIsMod(Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_MODERATION));
		
		return $config;
	}
}

?>