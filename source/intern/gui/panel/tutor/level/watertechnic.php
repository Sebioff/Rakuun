<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Watertechnic extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'watertechnic';
	}
	
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->technologies->hydropower >= 1);
	}
	
	public function getDescription() {
		return '
			Du hast die Voraussetzungen erfüllt um die Wassertechnik zu forschen.
			Damit kannst du anschließend Wasserkraftwerke bauen, um Energie zu produzieren.<br />
			<b>Forsche die Wassertechnik.</b>
		';
	}
}
?>