<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Buildflab extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->buildings->laboratory >= 3);
	}
	
	public function getDescription() {
		return '
			Wir wollen anfangen Energie zu produzieren.<br />
			<b>Baue das Forschungslabor auf Level 3 aus!</b>
		';
	}
}
?>