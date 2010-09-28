<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Citywall extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->buildings->cityWall >= 1);
	}
	
	public function getDescription() {
		return '
			Du kannst deine Verteidigungskraft auch auf eine andere Art steigern.
			Die Stadtmauer verstärkt deine Verteidigung um 4% je Stufe. 
			Die Stadtmauer kannst du maximal 3 mal ausbauen, was dir einen Bonus von 
			maximal 12% verschafft. Wir wollen mal die erste Stufe der Stadtmauer bauen.
			<br /><b>Baue die Stadtmauer auf Stufe 1</b>
		';
	}
}
?>