<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Faq extends Rakuun_Intern_GUI_Panel_Tutor_Tipp {
	public function __construct() {
		$this->internal = 'faq';
	}
	
	public function getDescription() {
		return '
			Wie lange geht ungefähr eine Runde?:
			<br/>Eine Runde geht ca. 2-4 Monate. Sobald das Spielziel erreicht wurde,
			startet eine neue Runde und es geht wieder von vorne los</br>
			Was bedeutet Farmen?:
			</br>Farmen bedeutet einem Spieler Ressourcen zu klauen</br>
			</br>Was bedeutet Bashen?:
			</br>Bashen bedeutet das zerschießen der Gebäude eines Spielers.</br>
		';
	}
}

?>