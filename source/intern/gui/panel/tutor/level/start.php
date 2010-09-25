<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Start extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function __construct() {
		$this->internal = 'start';
	}
	
	public function completed() {
		return true;
	}
	
	public function getDescription() {
		return '
			Hallo, ich bin Detlef, dein persönlicher Tutor für dieses Spiel.<br />
			Meine Aufgabe ist es, dir die ersten Schritte in der Welt Rakuuns zu zeigen.
			Zuerst werde ich dich durch die Spieloberfläche führen, bevor wir uns dem
			Aufbau deiner neuen Stadt widmen.<br />
			Wir befinden uns hier auf der Übersichtsseite.
			Hier findest du alle wichtigen Informationen auf einen Blick und kannst mit anderen
			Stadtoberhäuptern über die Shoutbox kommunizieren.<br />
			<b>Klicke auf "-&gt;" um fortzufahren!</b>
		';
	}
}
?>