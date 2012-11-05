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

class Rakuun_Intern_GUI_Panel_Tutor_Level_People extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return $user->buildings->clonomat >= 1;
	}
	
	public function getDescription() {
		return '
			Achtung Leutemangel! Damit du immer genügend Leute hast, um mehr Gebäude zu bauen
			und Arbeiter einzustellen, brauchst du mehr Leute. Der Clon-O-Mat (kurz COM)
			"produziert" mehr Leute für dich.<br />
			Schau mal im Techtree nach, was du dafür brauchst. du wirst feststellen,
			dass dir dafür noch die Gentechnik fehlt. Forsche dieses zunächst aus,
			bevor du mit dem Bau des Clon-O-Matens beginnen kannst.<br />
			<b>Baue Clon-O-Mat auf Stufe 1 und besetze ihn mit Arbeitern.</b>
		';
	}
}
?>