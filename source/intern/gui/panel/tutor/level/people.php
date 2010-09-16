<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_People extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'people';
	}
	
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return $user->buildings->clonomat >= 1;
	}
	
	public function getDescription() {
		return '
			Achtung Leutemangel! Damit du immer genügend Leute hast, um mehr Gebäude zu bauen
			und Arbeiter einzustellen, brauchst du mehr Leute. Der Clon-O-Mat (kurz COM)
			"produziert" mehr Leute für dich.<br />
			Schau mal im Techtree nach, was du dafür brauchst. du wirst feststellen, 
			dass dir dafür noch die Gentechnik fehlt. Forsche dieses zunächst aus, 
			bevor du mit dem Bau des Clon-O-Matens beginnen kannst.<br /> 
			<b>Baue Clon-O-Mat auf Stufe 1.</b>
		';
	}
}
?>