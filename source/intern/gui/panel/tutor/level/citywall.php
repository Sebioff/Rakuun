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

class Rakuun_Intern_GUI_Panel_Tutor_Level_Citywall extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->buildings->cityWall >= 1);
	}
	
	public function getDescription() {
		return '
			Du kannst deine Verteidigungskraft auch auf eine andere Art steigern.
			Die Stadtmauer verstärkt deine Verteidigung um 4% je Stufe.
			Die Stadtmauer kannst du maximal 3 mal ausbauen, was dir einen Bonus von
			maximal 12% verschafft. Wir wollen mal die erste Stufe der Stadtmauer bauen.
			<br /><b>Baue die Stadtmauer auf Stufe 1</b>
		';
	}
}
?>