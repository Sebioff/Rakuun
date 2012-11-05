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
 * shows all important Persons in this Game
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_User_VIPs extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/vips.tpl');
		
		//traverse all Groups
		$i = 0;
		foreach (Rakuun_GameSecurity::get()->getVIPGroups() as $group) {
			$table = new GUI_Panel_Table('group_'.$i);
			$header = array();
			$header[] = $group->name;
			if ($group->id == Rakuun_GameSecurity::GROUP_TEAM)
				$header[] = 'Aufgaben';
			$table->addHeader($header);
			
			//traverse all users in this group
			$users = array();
			$j = 0;
			foreach (Rakuun_GameSecurity::get()->getGroupUsers($group) as $user) {
				$line = array();
				$userlink = new Rakuun_GUI_Control_Userlink('userlink_'.$i * $j + $j, $user);
				$line[] = $userlink;
				if ($group->id == Rakuun_GameSecurity::GROUP_TEAM) {
					$privileges = array();
					foreach (Rakuun_TeamSecurity::get()->getUserGroups($user) as $teamgroup) {
						$privileges[] = $teamgroup->name;
					}
					$line[] = implode(', ', $privileges);
				}
				$table->addLine($line);
				++$j;
			}
			$this->addPanel($table);
			++$i;
		}
	}
}

?>