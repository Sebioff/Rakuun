<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Build2 extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'build2';
	}
	
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->buildings->ironmine >= 6 && $user->buildings->berylliummine >= 5);
	}
	
	public function getDescription() {
		$buildLink = new GUI_Control_Link('build', 'Baumenü', App::get()->getInternModule()->getSubmodule('build')->getUrl());
		return '
			Stärke deine Wirtschaft! Du wirst im Laufe des Spiels feststellen, 
			dass Eisen etwas wichtiger ist als Beryllium.<br />
			<b>Baue die Eisenmine auf 6 und Berylliummine auf Level 5 aus!</b>
		';
	}
}
?>