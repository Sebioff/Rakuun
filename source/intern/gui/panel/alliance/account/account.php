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

/**
 * Panel to display the alliance account
 */
class Rakuun_Intern_GUI_Panel_Alliance_Account extends GUI_Panel {
	const TYPE_USER_TO_ALLIANCE = 1;
	const TYPE_ALLIANCE_TO_USER = -1;
	const TYPE_ALLIANCE_BUILDING = 2;
	const TYPE_ALLIANCE_QUEST = 3;
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/account.tpl');
		$this->addPanel($iron = new GUI_Panel_Number('iron', Rakuun_User_Manager::getCurrentUser()->alliance->iron));
		$iron->setTitle('Eisen:');
		$this->addPanel($beryllium = new GUI_Panel_Number('beryllium', Rakuun_User_Manager::getCurrentUser()->alliance->beryllium));
		$beryllium->setTitle('Beryllium:');
		$this->addPanel($energy = new GUI_Panel_Number('energy', Rakuun_User_Manager::getCurrentUser()->alliance->energy));
		$energy->setTitle('Energie:');
		$this->addPanel($people = new GUI_Panel_Number('people', Rakuun_User_Manager::getCurrentUser()->alliance->people));
		$people->setTitle('Leute:');
	}
}

?>