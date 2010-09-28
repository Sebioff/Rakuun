<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Spydrones extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return $user->units->spydrone >= 1;
	}
	
	public function getDescription() {
		return '
			Du hast deine ersten Einheiten gebaut, sehr schön! Vielleicht möchtest du mal wissen,
			was der nächste Spieler in deiner Umgebung gebaut hat. Mit Hilfe der 
			Spionagesonden kannst du einen anderen Spieler ausspionieren und an
			seine Daten gelangen. Ein Spionagebericht liefert dir die Gebäudestufen,
			Anzahl seiner Einheiten, sowie Rohstoffe des Ausspionierten.
			Spionage ist ein wichtiger Bestandteil des Spiels. Sei immer einen
			Schritt deines Gegners voraus und erlange Kenntnis über den Zustand
			seiner Stadt. Vielleicht ist er ja wehrlos und du kannst ihm ein
			paar Rohstoffe klauen ;)
			<br /><b>Baue eine Spionagesonde!</b>
		';
	}
}
?>