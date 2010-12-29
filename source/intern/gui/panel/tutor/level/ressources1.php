<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Ressources1 extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Ressources;
	}
	
	public function getDescription() {
		$ressourcesLink = new GUI_Control_Link('resslink', 'Ressourcenübersicht ("Ressourcen -&gt; Übersicht")', App::get()->getInternModule()->getSubmodule('ressources')->getUrl());
		return '
			Deine Minen wurden jetzt ausgebaut, überprüfen wir das Ergebnis auf der '.$ressourcesLink->render().'.<br />
			<b>Begib dich zur Ressourcenübersicht.</b>
		';
	}
}
?>