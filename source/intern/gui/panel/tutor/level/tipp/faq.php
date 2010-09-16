<?php

// FIXME maybe in a new Page "FAQ"
class Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Faq extends Rakuun_Intern_GUI_Panel_Tutor_Tipp {
	public function __construct() {
		$this->internal = 'faq';
	}
	
	public function getDescription() {
		return '
			<b>Häufig gestellte Fragen:</b><br />
			<br />Wie lange geht ungefähr eine Runde?:
			<br /><i>Eine Runde geht ca. 2-4 Monate. Sobald das Spielziel erreicht wurde,
			startet eine neue Runde und es geht wieder von vorne los</i><br />
			<br />Was bedeutet Farmen?:
			<br /><i>Farmen bedeutet einem Spieler Ressourcen zu klauen</i><br />
			<br />Was bedeutet Bashen?:
			<br /><i>Bashen bedeutet das zerschießen der Gebäude eines Spielers.</i><br />
			<br /><b>klicke auf "weiter" um fortzufahren!</b>
		';
	}
}

?>