<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Tickets extends Rakuun_Intern_GUI_Panel_Tutor_Tipp {
	public function __construct() {
		$this->internal = 'tickets';
	}
	
	public function getDescription() {
		return '
			TIPP: Solltest du wider erwarten mal ein Fehler entdecken oder wenn du Vorschläge hast,
			wie wir das Spiel verbessern können, dann schreibe uns einfach ein Ticket.
			</br>Dies kannst du ganz einfach hier tun:
			</br><a href="http://tickets.rakuun.de">zum Ticketsystem</a>
		';
	}
}

?>