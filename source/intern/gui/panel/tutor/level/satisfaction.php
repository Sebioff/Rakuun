<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Satisfaction extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return ((Rakuun_Intern_Production_Influences::getPeopleSatisfactionRate() * 100) - 100) >= 10;
	}
	
	public function getDescription() {
		return '
			Die Zufriedenheit deiner Bürger beeinflusst die Produktion der Ressourcen.
			Je zufriedener deine Leute sind, desto mehr produzieren sie auch.
			Wenn dich deine Bürger verehren hast du die maximale Zufriedenheit deiner Leute hergestellt.
			Sie produzieren dann 10% mehr Ressourcen als normal.
			Um die Zufriedenheit deiner Bürger zu steigern musst du Freizeitparks bauen.
			<br /><b>Baue nun dein Freizeitpark so aus, bis dich deine Leute verehren.</b>
			 
		';
	}
}

?>