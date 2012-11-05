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

class Rakuun_Intern_GUI_Panel_Board_Meta extends Rakuun_Intern_GUI_Panel_Board {
	public function __construct($name, $title = '') {
		$this->config = self::getConfig();
		
		parent::__construct($name, $title);
	}
	
	public static function getConfig() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$config = new Board_Config();
		$options = array();
		$options['conditions'][] = array('meta = ?', $user->alliance->meta);
		$config->setBoardsContainer(Rakuun_DB_Containers::getBoardsMetaContainer()->getFilteredContainer($options));
		$board = new DB_Record();
		$board->meta = $user->alliance->meta;
		$config->setBoardRecord($board);
		$config->setPostingsContainer(Rakuun_DB_Containers::getBoardsMetaPostingsContainer());
		$posting = new DB_Record();
		$posting->user = $user;
		$config->setPostingRecord($posting);
		$config->setVisitedContainer(Rakuun_DB_Containers::getBoardsMetaLastVisitedContainer());
		$config->setBoardModule(App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('meta'));
		$config->setUserIsMod(Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_MODERATION));
		
		return $config;
	}
}
?>