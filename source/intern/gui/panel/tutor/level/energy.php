<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Energy extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'energy';
	}
	
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->buildings->hydropowerPlant >= 5);
	}
	
	public function getDescription() {
		return '
			Wir können nun anfangen Energie zu produzieren.
			Anfangs wirst du nicht so viel Energie benötigen. Level 5 reicht
			für den Anfang völlig aus.<br />
			<b>Baue das Wasserkraftwerk auf Level 5 aus!</b>
		';
	}
}
?>