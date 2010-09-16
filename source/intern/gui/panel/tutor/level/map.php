<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Map extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'map';
	}
	
	public function completed() {
		return Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Map;
	}
	
	public function getDescription() {
		$link = new GUI_Control_Link('maplink', 'Karte', App::get()->getInternModule()->getSubmodule('map')->getUrl());
		return '
			Hast du dir schonmal die '.$link->render().' angeschaut? Dort kannst
			du die Position deiner Stadt, sowie die der anderen Spieler sehen.
			Hier kannst du auch Angriffe auf andere Spieler starten. Dies solltest
			du jedoch erst wagen, sobald du andere Spieler ausspionieren kannst.
			Dazu später mehr...
			<br/><b>Gehe auf die Karte!</b>
		';
	}
}
?>