<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Firstmilitary extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'firstmilitary';
	}
	
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->units->inra >= 100);
	}
	
	public function getDescription() {
		return '
			Das Militär ist wesentlicher Bestandteil dieses Spiels. 
			Ohne Einheiten wird man sich nicht gegen die Feinde wehren können.
			Um in diesem Spiel erfolgreich sein zu können, muss man viele Einheiten bauen.
			Die Einheiten dienen in erster Linie zum verteidigen der eigenen Stadt
			und in zweiter Linie dem angreifen feindlicher Städte.
			Mit den Einheiten lassen sich gegnerische Städte ausplündern und Gebäude zerstören,
			um diesen Spieler zu schwächen.
			Schaue nun im Techtree nach welche Voraussetzungen dir noch für die erste Einheit 
			Infanterie-Rakuuraner fehlen und stelle damit deine erste Verteidigung zur Verfügung.
			<br/><b>Baue nun 100 Infanterie-Rakuuraner!</b>
		';
	}
}
?>