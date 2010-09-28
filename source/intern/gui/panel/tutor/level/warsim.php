<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Warsim extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Warsim;
	}
	
	public function getDescription() {
		$link = new GUI_Control_Link('warsimlink', 'WarSim', App::get()->getInternModule()->getSubmodule('warsim')->getUrl());
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