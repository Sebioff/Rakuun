<?php

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