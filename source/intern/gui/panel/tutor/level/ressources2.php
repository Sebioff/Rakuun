<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Ressources2 extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Ressources;
	}
	
	public function getDescription() {
		$ressourcesLink = new GUI_Control_Link('resslink', 'Ressourcenübersicht', App::get()->getInternModule()->getSubmodule('ressources')->getUrl());
		return '
			Deine Arbeiter haben ihre Arbeit aufgenommen und produzieren nun zusätzliche Rohstoffe.
			Die Veränderung der Produktionsrate solltest du dir auch wieder auf der '.$ressourcesLink->render().' angucken.<br />
			Abgesehen von der produzierten Menge Rohstoffe erhälst du hier auch eine Übersicht über deine Lagerkapazitäten,
			sowie eine ungefähre Angabe, für wie lang diese Kapazitäten bei aktueller Produktionsrate aushalten.<br />
			<b>Begib dich zurück zur Ressourcenübersicht.</b>
		';
	}
}
?>