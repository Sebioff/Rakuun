<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Sensorbay extends Rakuun_Intern_GUI_Panel_Tutor_Tipp {
	public function __construct() {
		$this->internal = 'sensorbay';
	}
	
	public function getDescription() {
		return '
			TIPP: Es gibt getarnte Einheiten in diesem Spiel. Um Angriffe mit
			getarnten Einheiten sehen zu können, brauchst du ein Sensorfeld.
			Jedoch reicht das Sensorfeld nur für eine bestimmte Reichweite.
			Je höher dein Sensorfeld ist, desto früher kannst du getarnte Angriffe sehen.
			<br /><b>Klicke auf "Weiter" um fortzufahren!</b>
		';
	}
}

?>