<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Build1 extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->buildings->ironmine >= 2 && $user->buildings->berylliummine >= 2);
	}
	
	public function getDescription() {
		$buildLink = new GUI_Control_Link('build', 'Baumenü', App::get()->getInternModule()->getSubmodule('build')->getUrl());
		return '
			Das wichtigste zu Beginn ist die Produktion von Rohstoffen zu erhöhen.
			Im Moment kannst du lediglich Eisen und Beryllium abbauen, diese bilden die Grundlage
			aller Ausbauten in Rakuun. Um diese Minen zu erhöhen, solltest du dich ins '.$buildLink->render().' begeben.<br />
			<b>Baue die Eisen- und Berylliumminen auf Level 2 aus!</b>
		';
	}
}
?>