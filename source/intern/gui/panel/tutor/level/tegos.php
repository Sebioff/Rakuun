<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tegos extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'tegos';
	}
	
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->units->tego >= 100);
	}
	
	public function getDescription() {
		return '
			Infanterie-Rakuuraner sind schwache Einheiten und sollten daher nur
			am Anfang gebaut werden. Die nächstbessere Einheit ist der Tego.
			Dieser hat mehr Angriffs -sowie Verteidigungskraft und ist zudem
			der schnellste Panzer in diesem Spiel.
			Schau dir erstmal an, welche Voraussetzungen dir für den Tego noch fehlen.
			Du wirst feststellen, dass dir noch einige Techniken und Gebäude fehlen.
			Forsche und baue sie, um Tegos bauen zu können.
			Tipp: vernachlässige deine Wirtschaft während der Forschungszeit nicht.
			Die Forschungen werden viel Zeit in Anspruch nehmen. Während dieser Zeit 
			kannst du weiter Eisen -und Berylliumminen bauen.
			<br/><b>Baue 100 Tegos!</b>
		';
	}
}
?>