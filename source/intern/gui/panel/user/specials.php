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

class Rakuun_Intern_GUI_Panel_User_Specials extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/specials.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();
		
		$this->addPanel($specials = new GUI_Panel_Table('specials', 'Specials'));
		$specials->addHeader(array('Name', 'Effekt'));
		
		$names = Rakuun_User_Specials::getNames();
		$effects = Rakuun_User_Specials::getEffects();
		
		//databases
		$options = array();
		$options['conditions'][] = array('identifier IN ('.implode(', ', Rakuun_User_Specials_Database::getDatabaseIdentifiers()).')');
		$options['conditions'][] = array('user = ?', $user);
		$options['conditions'][] = array('active = ?', true);
		$databases = Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->select($options);
		
		foreach ($databases as $database) {
			$line = array();
			$line[] = $names[$database->identifier];
			$line[] = $effects[$database->identifier];;
			$specials->addLine($line);
		}
		
		//user specific Specials
		//TODO
	}
}

?>