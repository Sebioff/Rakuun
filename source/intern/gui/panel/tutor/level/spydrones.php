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

class Rakuun_Intern_GUI_Panel_Tutor_Level_Spydrones extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return $user->units->spydrone >= 1;
	}
	
	public function getDescription() {
		return '
			Du hast deine ersten Einheiten gebaut, sehr schön! Vielleicht möchtest du mal wissen,
			was der nächste Spieler in deiner Umgebung gebaut hat. Mit Hilfe der
			Spionagesonden kannst du einen anderen Spieler ausspionieren und an
			seine Daten gelangen. Ein Spionagebericht liefert dir die Gebäudestufen,
			Anzahl seiner Einheiten, sowie Rohstoffe des Ausspionierten.
			Spionage ist ein wichtiger Bestandteil des Spiels. Sei immer einen
			Schritt deines Gegners voraus und erlange Kenntnis über den Zustand
			seiner Stadt. Vielleicht ist er ja wehrlos und du kannst ihm ein
			paar Rohstoffe klauen ;)
			<br /><b>Baue eine Spionagesonde!</b>
		';
	}
}
?>