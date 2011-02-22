<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Profile extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Profile;
	}
	
	public function getDescription() {
		if ($module = App::get()->getInternModule()->getSubmodule('profile'))
			$profilLink = new GUI_Control_Link('profillink', 'Profilseite ("Infos -&gt; Profil")', $module->getUrl());
		else
			$profilLink = new GUI_Panel_Text('profillink', 'Profilseite (nicht verfügbar)');
		return '
			Begib dich jetzt zuerst auf deine '.$profilLink->render().'. Hier kannst du deine persönlichen
			Einstellungen, wie e-Mail Adresse und Passwort ändern.<br />
			Vielleicht möchtest du deiner Stadt auch einen persönlicheren Namen geben?<br />
			<b>Besuche die Profilseite!</b>
		';
	}
}
?>