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
 * Parent class to actives, newoffer and offers to provide some constants.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Diplomacy extends GUI_Panel {
	//TODO: delete records marked as 'STATUS_DELETED' from database after 'notice' hours
	const RELATION_AUVB = 0;
	const RELATION_NAP = 1;
	const RELATION_WAR = 2;
	
	const STATUS_NEW = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_DELETED = 2;
	
	public function getNameForRelation($relation) {
		switch ($relation) {
			case self::RELATION_AUVB:
				return 'AuVB';
			case self::RELATION_NAP:
				return 'NAP';
			case self::RELATION_WAR:
				return 'Krieg';
		}
	}
}
?>