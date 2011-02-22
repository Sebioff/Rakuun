<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Attdeforder extends Rakuun_Intern_GUI_Panel_Tutor_Tipp {
	public function getDescription() {
		if ($module = App::get()->getInternModule()->getSubmodule('map'))
			$link = new GUI_Control_Link('maplink', 'Karte', $module->getUrl());
		else
			$link = new GUI_Panel_Text('maplink', 'Karte (nicht verfügbar)');
		return '
			TIPP: Du kannst bestimmen welche Einheiten zuerst kämpfen. Auf der
			'.$link->render().' kannst du die Reihenfolge mit den Pfeilen ändern.
			Obenstehende Einheiten fallen zuerst im Kampf, untenstehende zuletzt.
			So kannst du dir deine wichtigen Einheiten ans Ende der Kampfreihenfolge
			stellen. Einen Einfluss auf das Ergebnis des Kampfes hat die Reihenfolge
			jedoch nicht! Sie bestimmt nur welche Einheiten zuerst fallen.
			<br /><b>klicke auf "-&gt;" um fortzufahren!</b>
		';
	}
}

?>