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
 * Panel that displays all members of an alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Members extends GUI_Panel {
	private $alliance = null;
	
	public function __construct($name, Rakuun_DB_Alliance $alliance) {
		parent::__construct($name);

		$this->setTemplate(dirname(__FILE__).'/members.tpl');
		$this->alliance = $alliance;
		$this->params->members = $alliance->members;
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_DB_Alliance
	 */
	public function getAlliance() {
		return $this->alliance;
	}
}

?>