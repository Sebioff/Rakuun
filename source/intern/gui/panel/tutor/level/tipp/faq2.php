<?php

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tipp_Faq2 extends Rakuun_Intern_GUI_Panel_Tutor_Tipp {
	public function getDescription() {
		return '
			<u><b>Worterklärungen:</b></u><br />
			<br /><b>IGM:</b> Steht für I(n) G(ame) M(essage). Also eine Nachricht im Spiel.<br />
			<b>Att:</b> Die Einheit für die Angriffskraft der Armee. Wird zudem auch verwendet um zu berichten wen man angreift(z.B.: Ich atte Max Mustermann).<br />
			<b>Deff:</b> Die Einheit für die Verteidigungskraft der Armee.<br />
			<b>Allianz:</b> Eine Allianz ist ein Zusammenschluss von Spielern unter einer „Flagge“. Sie wird i.d.R. vom Leiter der Allianz gegründet und im Verlaufe der Runde repräsentiert und geleitet.<br />
			<b>Meta:</b> Die „Weiterentwicklung“ der Allianz. Eine Meta wird von einer Allianz gegründet. Ihr können sich weitere Allianzen anschließen. <br />
			<br /><br /><br /><b>Datenbankteile:</b> Zum Bau der Dancertia benötigte Wissensfragmente(im weiteren nur noch DB(s) genannt), die sich anhand der Farbe(rot/blau/grün/gelb/braun) und des Bonus unterscheiden lassen. Der „globale“ Bonus eines DBs überträgt sich auf die gesamte Allianz/Meta. Der „lokale“ Bonus(+4% Verteidigungskraft) beschränkt sich auf die Person die das DB zum aktuellen Zeitpunkt beschützt.<br />
			<b>Datenbankdetektor:</b> Detektoren die benötigt werden um einzelne DBs auf der Karte sehen zu können. Jede Ausbaustufe der Detektoren erhöht die Wachstumsrate des „globalen“ Bonus der DBs. Sie können nur von Allianzen gebaut werden.<br />
			<b>Schildgenerator:</b> Die Schildgeneratoren dienen dazu die Dancertia vor Angreifen zu schützen. Jeder Spieler, der ein Schildgenerator besitzt, verteidigt automatisch die Dancertia mit seiner eigenen Fleet. Die Angreifer müssen jedes Schild zerstören, um den Sieg zu vereiteln. Es ist daher ratsam innerhalb der Meta so viele Schilde wie möglich zu bauen.<br />
			<b>Dancertia:</b> "Mutterschiff" mit dem die Flucht von Rakuun gelingt.<br />
			<br /><b>klicke auf "-&gt;" um fortzufahren!</b>
		';
	}
}

?>