<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Goal extends Rakuun_Intern_GUI_Panel_Tutor_Tipp {
	public function __construct() {
		$this->internal = 'goal';
	}
	
	public function getDescription() {
		return '
			Ziel des Spiels ist der Bau und der Start der Dancertia (kurz DC).
			Diejenige Meta hat gewonnen, die es schafft die DC zu bauen und vor den Rest der Spieler zu verteidigen! 
			Auf der Karte sind insgesamt 5 Datenbankteile (kurz DB) verteilt. 
			Um die DC bauen zu können braucht die Meta 3 von 5 Datenbankteilen. Welche spielt keine Rolle. 
			Jeder einzelne Spieler muss 3 DBs erobern um ein Schildgenerator zu bauen, welcher die DC schützen soll.
			Jeder Schildgenerator der sich in der Meta befindet schützt die DC vor den Angreifern. 
			Man schützt also mit seiner eigenen Stadt (und Def) die DC seiner Meta und bringt damit den Sieg einen Schritt näher.
			Meint die Meta genügend Schilde gebaut zu haben, so wird sie die DC in Auftrag geben. Der Bau dauert 3 Tage.
			Nach Fertigstellung der DC braucht diese 5 Tage um zu starten. 
			Während dieser Zeit haben die anderen Spieler die Chance alle Schildgeneratoren zu zerstören, 
			um den Start der DC und damit letztlich auch den Sieg zu verhindern.
			<br /><b>klicke auf "weiter" um fortzufahren!</b>
		';
	}
}

?>