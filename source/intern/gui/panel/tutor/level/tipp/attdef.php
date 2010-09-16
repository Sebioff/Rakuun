<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Attdef extends Rakuun_Intern_GUI_Panel_Tutor_Tipp {
	public function __construct() {
		$this->internal = 'attdef';
	}
	
	public function getDescription() {
		$link = new GUI_Control_Link('summarylink', 'Zusammenfassung', App::get()->getInternModule()->getSubmodule('summary')->getUrl());
		return '
			TIPP: Achte stets auf deine Verteidigungskraft (kurz Def). Denn nur damit kannst du deine
			Stadt vor Angreifern schützen. Je höher deine Def, desto sicherer ist deine Stadt.
			Die Angriffskraft (Att) brauchst du um andere Städte anzugreifen. Je höher deine Att ist,
			desto mehr Def kannst du beim Gegner zerstören. Hast du mehr Att, als dein Gegner Def, so kannst du 
			seine Stadt zerstören und Ressourcen plündern.
			<br />TIPP2: Deine Def sollte nie höher sein, als dein Att. Ansonsten läufst du Gefahr für andere Spieler
			ein begehrtes Ziel zu sein.
			<br /><b>Gehe auf die '.$link->render().' , um deine aktuellen Angriffs -und Verteidigungswerte zu überprüfen</b>
		';
	}
}

?>