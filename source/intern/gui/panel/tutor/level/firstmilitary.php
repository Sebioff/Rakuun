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

class Rakuun_Intern_GUI_Panel_Tutor_Level_Firstmilitary extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	const REQUIRED_INRAS = 50;
	
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->units->inra >= self::REQUIRED_INRAS);
	}
	
	public function getDescription() {
		return '
			Das Militär ist wesentlicher Bestandteil dieses Spiels.
			Ohne Einheiten wird man sich nicht gegen die Feinde wehren können.
			Um in diesem Spiel erfolgreich sein zu können, muss man viele Einheiten bauen.
			Die Einheiten dienen in erster Linie zum verteidigen der eigenen Stadt
			und in zweiter Linie dem angreifen feindlicher Städte.
			Mit den Einheiten lassen sich gegnerische Städte ausplündern und Gebäude zerstören,
			um diesen Spieler zu schwächen.
			Schaue nun im Techtree nach welche Voraussetzungen dir noch für die erste Einheit
			Infanterie-Rakuuraner fehlen und erstelle damit deine erste Verteidigung.
			<br/><b>Baue nun '.self::REQUIRED_INRAS.' Infanterie-Rakuuraner!</b>
		';
	}
}
?>