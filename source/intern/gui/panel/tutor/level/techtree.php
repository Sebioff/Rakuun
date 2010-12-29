<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Techtree extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Techtree;
	}
	
	public function getDescription() {
		$techtreeLink = new GUI_Control_Link('techtree', 'Techtree ("Produktion -&gt; Techtree")', App::get()->getInternModule()->getSubmodule('techtree')->getUrl());
		return '
			Mit Eisen und Beryllium als Rohstoffe wirst du allein nicht weiterkommen.
			Energie ist ein ebenso wichtiger Rohstoff. Bevor du ihn jedoch produzieren
			kannst, musst du Wassertechnik forschen. Hierfür benötigst du Forschungslabor 3.
			Welche Voraussetzungen du für bestimmte Gebäude oder Techniken benötigst,
			kannst du immer im '.$techtreeLink->render().' erfahren.<br />
			<b>Schaue dir jetzt den Techtree an</b>
		';
	}
}
?>