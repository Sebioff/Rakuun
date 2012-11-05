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

class Rakuun_Intern_Mode_Standard extends Rakuun_Intern_Mode {
	public function onTick() { }
	
	public function onNewUser(Rakuun_DB_User $user) { }
	
	/**
	 * @return Rakuun_Intern_Map_CoordinateGenerator
	 */
	public function getCoordinateGenerator() {
		return new Rakuun_Intern_Map_CoordinateGenerator();
	}
	
	public function getBitMapImage() {
		return imagecreatefrompng(PROJECT_PATH.'/www/images/map.png');
	}
	
	public function getMapImagePath() {
		return Router::get()->getStaticRoute('images', 'map_large.png');
	}
	
	public function allowFoundAlliances() {
		return true;
	}
	
	public function allowLeaveAlliances() {
		return true;
	}
	
	public function allowKickFromAlliances() {
		return true;
	}
	
	public function allowDiplomacy() {
		return true;
	}
	
	public function allowUserChangeNameColor() {
		return true;
	}
}

?>