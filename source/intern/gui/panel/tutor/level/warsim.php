<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Warsim extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Warsim;
	}
	
	public function getDescription() {
		if ($module = App::get()->getInternModule()->getSubmodule('warsim'))
			$link = new GUI_Control_Link('warsimlink', 'WarSim ("Militär -&gt; WarSim")', $module->getUrl());
		else
			$link = new GUI_Panel_Text('warsimlink', 'WarSim (nicht verfügbar)');
		return '
			Sicherlich hast du dir schonmal überlegt, ob es sich lohnen würde einen
			bestimmten Spieler anzugreifen. Mit Hilfe des '.$link->render().'s kannst
			du dir den Kampf schon vorher berechnen lassen. Er liefert dir den
			exakten Ausgang des Kampfes, bevor du ihn überhaupt gestartet hast.
			<br/><b>Schau dir den WarSim an!</b>
		';
	}
}
?>