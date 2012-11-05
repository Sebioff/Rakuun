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

class Rakuun_Intern_GUI_Panel_Tutor_Level_Tegos extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->units->tego >= 100);
	}
	
	public function getDescription() {
		return '
			Infanterie-Rakuuraner sind schwache Einheiten und sollten daher nur
			am Anfang gebaut werden. Die nächstbessere Einheit ist der Tego.
			Dieser hat mehr Angriffs -sowie Verteidigungskraft und ist zudem
			der schnellste Panzer in diesem Spiel.
			Schau dir erstmal an, welche Voraussetzungen dir für den Tego noch fehlen.
			Du wirst feststellen, dass dir noch einige Techniken und Gebäude fehlen.
			Forsche und baue sie, um Tegos bauen zu können.<br />
			Tipp: vernachlässige deine Wirtschaft während der Forschungszeit nicht.
			Die Forschungen werden viel Zeit in Anspruch nehmen. Während dieser Zeit
			kannst du weiter Eisen -und Berylliumminen bauen.
			<br/><b>Baue 100 Tegos!</b>
		';
	}
}
?>