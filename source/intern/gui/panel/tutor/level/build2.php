<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Build2 extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'build2';
	}
	
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->buildings->ironmine >= 8 && $user->buildings->berylliummine >= 6);
	}
	
	public function getDescription() {
		$buildLink = new GUI_Control_Link('build', 'Baumenü', App::get()->getInternModule()->getSubmodule('build')->getUrl());
		return '
			Stärke deine Wirtschaft! Du wirst im Laufe des Spiels feststellen, 
			dass Eisen etwas wichtiger ist als Beryllium. 
			Dank der Bauschleife kannst du bis zu 5 Gebäude in die Warteschleife stellen.
			Dies ist für dich kostenlos.<br />
			<b>Baue die Eisenmine auf Level 8 und Berylliummine auf Level 6 aus!</b>
		';
	}
}
?>