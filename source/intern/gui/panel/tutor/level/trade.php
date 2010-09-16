<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Trade extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'trade';
	}
	
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->buildings->moleculartransmitter >= 1)
			&& ($user->buildings->stockMarket >= 1);
	}
	
	public function getDescription() {
		return '
			Mit deinen Resourcen kannst du auch Handel betreiben. Es gibt hier 2 Möglichkeiten:
			<br />1. der Molekulartransmitter (kurz MKT): Mit dessen Hilfe kannst du Ressourcen direkt an andere Spieler senden.
			<br />2. die Börse: Hier werden Ressourcen zu aktuellen Kursen angeboten. Angebot und Nachfrage regulieren hier den Preis. 
			
			Für beide Handelsmöglichkeiten gilt:
			<br />1.Das Handeln ist im Noobschutz nicht möglich
			<br />2.Du kannst nur eine bestimmte Menge pro Tag handeln. Die maximale Menge kannst du mit dem Ausbau des jeweiligen Gebäudes erhöhen.
			
			<br /><b>Baue nun einen Molekulartransmitter sowie eine Börse!</b>
		';
	}
}

?>