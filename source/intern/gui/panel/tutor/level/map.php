<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Map extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Map;
	}
	
	public function getDescription() {
		if ($module = App::get()->getInternModule()->getSubmodule('map'))
			$link = new GUI_Control_Link('maplink', 'Karte ("Militär -&gt; Karte")', $module->getUrl());
		else
			$link = new GUI_Panel_Text('maplink', 'Karte (nicht verfügbar)');
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