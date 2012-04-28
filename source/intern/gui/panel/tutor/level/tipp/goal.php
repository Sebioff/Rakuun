<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Goal extends Rakuun_Intern_GUI_Panel_Tutor_Tipp {
	public function getDescription() {
		return '
			Das Ziel des Spiels ist das Bauen, Verteidigen und Starten der Dancertia gegen den Rest Rakuuns!<br />
			<br />Um dies zu erreichen bedarf es ein paar Vorkehrungen:<br />
			<br /><b>1.</b> Die Allianz muss mindestens 3 der 5 Datenbankdetektoren auf Stufe 1 ausbauen um 3 von insgesamt 5 DBs zu sehen. Ein DB kann erobert werden, indem der Spieler, der es hält, angegriffen und seine Armee zerstört wird. Ist seine Armee vollständig zerstört, so ist das DB freigelegt und kann erobert werden. Zum erobern eines DBs ist ein Angriff mit min. 1000 Att erforderlich.
			<br /><b>2.</b> Die Allianz/Meta muss im Besitz von 3 der 5 DBs sein. Welche dies sind spielt keine Rolle.
			<br /><b>3.</b> Ist die 2. Voraussetzung erfüllt, so muss die Meta den Dancertia-Raumhafen bauen.
			<br /><b>4.</b> Nachdem der Raumhafen fertiggestellt wurde, ist der Bau des Schildgenerators freigeschaltet.
			<br /><br /><br /><b>5.</b> Nun müssen die Datenbankteile an jeden Spieler verteilt werden, der ein Schild bauen soll. Um ein Schild in Bau geben zu können, muss der entsprechende Spieler 3 DBs besitzen.
			<br /><b>6.</b> Alle Allianzleiter können in der Metaübersicht sehen, welche Schilde bereits fertiggestellt wurden. Meint der Leiter genug Schilde zum Verteidigen der Dancertia zu haben, so gibt er diese in Bau.
			<br /><b>7.</b> Ist die Dancertia fertiggestellt, muss sie noch 5 Tage, 00:00:00 Minuten geschützt werden. Existiert nach Ablauf des Countdowns noch mindestens ein Schild, so hat die Meta gewonnen. Andernfalls wurde die Dancertia abgeschossen und es muss ein neuer Versuch (von wem auch immer) unternommen werden. Auf der Startseite wird während des Countdowns ein Schild aufgedeckt sowie die Anzahl der Gesamtschilde preisgegeben. Es muss aber nicht das Schild auf der Startseite als erstes zerstört werden, stattdessen kann es auch jedes andere beliebige Schild sein.<br />
			<br />Weitere Fragen können gerne in der Shoutbox oder per IGM an einen der Supporter gestellt werden.<br />
			<br /><b>klicke auf "-&gt;" um fortzufahren!</b>
		
		';
	}
}

?>