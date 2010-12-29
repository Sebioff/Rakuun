<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Military2 extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->units->inra >= 200);
	}
	
	public function getDescription() {
		$link = new GUI_Control_Link('statistics', 'Statistik ("Infos -&gt; Statistik")', App::get()->getInternModule()->getSubmodule('statistics')->getUrl());
		return '
			Hast du deine Verteidigung im Blick? Überprüfe dies, indem du deine
			Verteidigungskraft mit der des Noobschutzes vergleichst.
			Diese findest du unter '.$link->render().' .
			Sie sollte in jedem Fall höher sein.
			Dort kannst du auch andere interessante Daten sehen,
			wie z.B. die durchschnittlichen Minen oder wieviele Einheiten es von
			jedem Typ gibt.
			Hinweis: der Noobschutz wird nach der Armeestärke berechnet.
			Armeestärke ist (Angriffskraft + Verteidigungskraft) / 2
			<br/><b>Schaue dir die Armeestärke des Noobschutzes an!</b>
		';
	}
}
?>