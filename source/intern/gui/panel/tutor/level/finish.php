<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Finish extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'finish';
	}
	
	public function completed() {
		return true;
	}
	
	public function getDescription() {
		return '
			Hiermit hast du das Tutorial abgeschlossen. Sollten noch Fragen offen sein,
			kannst du sie einfach in unserem Forum stellen.<br />
			Solltest du dort keine Antwort finden, steht dir der Support gern zur Seite.<br />
			Ansonsten wünscht dir das Rakuun-Team viel Vergnügen!
		';
	}
}
?>