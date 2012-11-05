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

class Rakuun_Intern_GUI_Panel_Board_Overview_Global extends Rakuun_Intern_GUI_Panel_Board_Overview_Base {
	public function init() {
		parent::init();
		
		$options = array();
		$options['conditions'][] = array('user_name = ?', Rakuun_User_Manager::getCurrentUser()->nameUncolored);
		$options['conditions'][] = array('round_number = ?', RAKUUN_ROUND_NAME);
		$globalBoards = $this->getBoards(
			Rakuun_DB_Containers_Persistent::getBoardsGlobalLastVisitedContainer()->getFilteredContainer($options),
			Rakuun_DB_Containers_Persistent::getBoardsGlobalContainer()
		);
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_List('list', Rakuun_Intern_GUI_Panel_Board_Global::getConfig(), $globalBoards));
		$this->addPanel(new GUI_Control_Link('boardlink', 'Zum Forum', App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('global')->getUrl()));
	}
}
?>