<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Sitter extends Rakuun_Intern_GUI_Panel_Tutor_Tipp {
	public function __construct() {
		$this->internal = 'sitter';
	}
	
	public function getDescription() {
		$link = new GUI_Control_Link('profilelink', 'Profil', App::get()->getInternModule()->getSubmodule('profile')->getUrl());
		return '
			TIPP: Du kannst einen Sitter in deinem '.$link->render().' eintragen. Dieser Spieler
			bekommt dann einen eingeschränkten Zugang zu deinem Account ohne dass
			er dein Passwort kennen muss.
			Dieser Spieler kann Gebäude und Einheiten bauen, sowie Forschungen in
			Auftrag geben. Dies kostet allerdings <b>5%</b> mehr, als wenn du selbst
			die Dinge in Auftrag gibst. Der Spieler, der dich sittet kann jedoch 
			keine Angriffe auf deiner Startseite sehen! 
			Einen Sitter zu haben ist jedoch sehr praktisch. So kann dich ein 
			Spieler vertreten, während du nicht online sein kannst,	z.B. wärend
			deiner Arbeitszeit oder im Urlaub.
			Einen Sitter kannst du im Profil eintragen und er kann jederzeit
			geändert werden.
			<br /><b>Klicke auf "Weiter" um fortzufahren!</b>
		';
	}
}

?>