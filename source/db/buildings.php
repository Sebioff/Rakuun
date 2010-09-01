<?php

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
	}
	
	/**
	 * Raises item level.
	 */
	public function raise($internalName, $deltaLevel = 1) {
		parent::raise($internalName, $deltaLevel);
		Rakuun_Intern_Event::onChangeBuildingLevel($this, $internalName, $deltaLevel, Rakuun_User_Manager::getCurrentUser());
	}
}

?>