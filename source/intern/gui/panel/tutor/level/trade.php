<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

class Rakuun_Intern_GUI_Panel_Tutor_Level_Trade extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->buildings->moleculartransmitter >= 1)
			&& ($user->buildings->stockMarket >= 1);
	}
	
	public function getDescription() {
		return '
			Mit deinen Resourcen kannst du auch Handel betreiben. Es gibt hier 2 Möglichkeiten:
			<br />1. der Molekulartransmitter (kurz MKT): Mit dessen Hilfe kannst du Ressourcen direkt an andere Spieler senden.
			<br />2. die Börse: Hier werden Ressourcen zu aktuellen Kursen angeboten. Angebot und Nachfrage regulieren hier den Preis.
			
			Für beide Handelsmöglichkeiten gilt:
			<br />1.Das Handeln ist im Noobschutz nicht möglich
			<br />2.Du kannst nur eine bestimmte Menge pro Tag handeln. Die maximale Menge kannst du mit dem Ausbau des jeweiligen Gebäudes erhöhen.
			
			<br /><b>Baue nun einen Molekulartransmitter sowie eine Börse!</b>
		';
	}
}

?>