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
 * Gameplay mode
 */
abstract class Rakuun_Intern_Mode {
	private static $currentModeInstance;

	/**
	 * @return Rakuun_Intern_Mode
	 */
	public static function getCurrentMode() {
		$modeClassName = RAKUUN_GAME_MODE;
		return (self::$currentModeInstance) ? self::$currentModeInstance : self::$currentModeInstance = new $modeClassName();
	}
	
	public abstract function onTick();
	/**
	 * Called if a new user account is created (before the user has actually been
	 * saved to the database)
	 */
	public abstract function onNewUser(Rakuun_DB_User $user);
	
	/**
	 * @return Rakuun_Intern_Map_CoordinateGenerator
	 */
	public abstract function getCoordinateGenerator();
	
	public abstract function getBitMapImage();
	public abstract function getMapImagePath();
	
	public abstract function allowFoundAlliances();
	public abstract function allowLeaveAlliances();
	public abstract function allowKickFromAlliances();
	public abstract function allowDiplomacy();
	public abstract function allowUserChangeNameColor();
}

?>