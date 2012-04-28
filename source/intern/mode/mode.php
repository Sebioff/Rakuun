<?php

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