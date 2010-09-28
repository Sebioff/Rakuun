<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Profile extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Profile;
	}
	
	public function getDescription() {
		$profilLink = new GUI_Control_Link('profillink', 'Profilseite', App::get()->getInternModule()->getSubmodule('profile')->getUrl());
		return '
			Begib dich jetzt zuerst auf deine '.$profilLink->render().'. Hier kannst du deine persönlichen
			Einstellungen, wie e-Mail Adresse und Passwort ändern.<br />
			Vielleicht möchtest du deiner Stadt auch einen persönlicheren Namen geben?<br />
			<b>Besuche die Profilseite!</b>
		';
	}
}
?>