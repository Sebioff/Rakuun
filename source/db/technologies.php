<?php

/**
 * @property Rakuun_DB_User $user
 */
class Rakuun_DB_Technologies extends Rakuun_DB_CityItems {
	/**
	 * Lowers the item level.
	 */
	public function lower($internalName, Rakuun_DB_User $destroyer, $deltaLevel = 1) {
		parent::lower($internalName, $destroyer, $deltaLevel);
		Rakuun_Intern_Event::onChangeTechnologyLevel($this, $internalName, $deltaLevel * -1, $destroyer);
		$this->user->recalculatePoints();
	}
	
	/**
	 * Raises item level.
	 */
	public function raise($internalName, $deltaLevel = 1) {
		parent::raise($internalName, $deltaLevel);
		Rakuun_Intern_Event::onChangeTechnologyLevel($this, $internalName, $deltaLevel, Rakuun_User_Manager::getCurrentUser());
		$this->user->recalculatePoints();
	}
}

?>