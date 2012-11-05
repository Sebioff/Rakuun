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
 * @property Rakuun_DB_User $user
 */
class Rakuun_DB_Buildings extends Rakuun_DB_CityItems {
	/**
	 * Lowers the item level.
	 */
	public function lower($internalName, Rakuun_DB_User $destroyer, $deltaLevel = 1) {
		parent::lower($internalName, $destroyer, $deltaLevel);
		Rakuun_Intern_Event::onChangeBuildingLevel($this, $internalName, $deltaLevel * -1, $destroyer);
		$this->user->recalculatePoints();
		$this->user->addXP(-1);
	}
	
	/**
	 * Raises item level.
	 */
	public function raise($internalName, $deltaLevel = 1) {
		parent::raise($internalName, $deltaLevel);
		Rakuun_Intern_Event::onChangeBuildingLevel($this, $internalName, $deltaLevel, Rakuun_User_Manager::getCurrentUser());
		$this->user->recalculatePoints();
		$this->user->addXP(1);
	}
}

?>