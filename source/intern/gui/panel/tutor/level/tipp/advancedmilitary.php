<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Advancedmilitary extends Rakuun_Intern_GUI_Panel_Tutor_Tipp {
	public function __construct() {
		$this->internal = 'advancedmilitary';
	}
	
	public function getDescription() {
		$link = new GUI_Control_Link('statistics', 'Statistik', App::get()->getInternModule()->getSubmodule('statistics')->getUrl());
		return '
			Sehr schön! Du kannst nun Infanterie-Rakuuraner und Tegos bauen.
			Im späteren Spielverlauf empfiehlt es sich noch fortschrittlichere Einheiten
			zu bauen. Wie wäre es z.B. mit Flieger? Damit lässt es sich gut über
			das Wasser auf der Karte fliegen. Dies verkürzt Wegzeiten. Oder möchtest
			du viel Def aufbauen, dann eignen sich hervorragend Türme. 
			<br />Egal wofür du dich auch entscheidest. Forsche nicht zu früh auf
			fortschrittlichere Einheiten, sondern baue erstmal deine Wirtschaft 
			und Verteidigung aus.
			<br/><b>klicke auf "weiter" um fortzufahren!</b>
		';
	}
}
?>