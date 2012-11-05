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

/**
 * FIXME this tutor level is never used!
 */
class Rakuun_Intern_GUI_Panel_Tutor_Level_Military2 extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->units->inra >= 200);
	}
	
	public function getDescription() {
		if ($module = App::get()->getInternModule()->getSubmodule('statistics'))
			$link = new GUI_Control_Link('statistics', 'Statistik ("Infos -&gt; Statistik")', $module->getUrl());
		else
			$link = new GUI_Panel_Text('statistics', 'Statistik (nicht verfügbar)');
		return '
			Hast du deine Verteidigung im Blick? Überprüfe dies, indem du deine
			Verteidigungskraft mit der des Noobschutzes vergleichst.
			Diese findest du unter '.$link->render().' .
			Sie sollte in jedem Fall höher sein.
			Dort kannst du auch andere interessante Daten sehen,
			wie z.B. die durchschnittlichen Minen oder wieviele Einheiten es von
			jedem Typ gibt.
			Hinweis: der Noobschutz wird nach der Armeestärke berechnet.
			Armeestärke ist (Angriffskraft + Verteidigungskraft) / 2
			<br/><b>Schaue dir die Armeestärke des Noobschutzes an!</b>
		';
	}
}
?>