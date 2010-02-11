<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Alliance extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'alliance';
	}
	
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->alliance != null);
	}
	
	public function getDescription() {
		$allianceLink = new GUI_Control_Link('alliance', 'Allianz', App::get()->getInternModule()->getSubmodule('alliance')->getUrl());
		return '
			Die Allianz ist ein wesentlicher Bestandteil des Spiels. Ohne Allianz kann man das Spiel nicht gewinnen.
			Hier wird dir geholfen und der Zusammenhalt gestärkt. Eine Allianz bietet dir zudem einige Vorteile wie z.B.:
			<br />du kannst deine Ressourcen in der Allianzkasse sparen und dir oder anderen Spielern damit unterstützen
			<br />Ressourcen und Armeen deiner Allianzmitglieder einsehen
			<br />Bündnisse mit anderen Allianzen schließen und damit Verbündete gewonnen oder
			<br />anderen Allianzen den Krieg erklären um an die Herrschaft Rakuuns zu gelangen
			<br />trete daher nun einer '.$allianceLink->render().' deiner Wahl bei! 
		';
	}
}

?>