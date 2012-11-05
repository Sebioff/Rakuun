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

class Rakuun_Intern_GUI_Panel_Tutor_Level_Build1 extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->buildings->ironmine >= 2 && $user->buildings->berylliummine >= 2);
	}
	
	public function getDescription() {
		$buildLink = new GUI_Control_Link('build', 'Baumenü ("Produktion -&gt; Gebäude")', App::get()->getInternModule()->getSubmodule('build')->getUrl());
		return '
			Das wichtigste zu Beginn ist die Produktion von Rohstoffen zu erhöhen.
			Im Moment kannst du lediglich Eisen und Beryllium abbauen, diese bilden die Grundlage
			aller Ausbauten in Rakuun. Um diese Minen zu erhöhen, solltest du dich ins '.$buildLink->render().' begeben.<br />
			<b>Baue die Eisen- und Berylliumminen auf Level 2 aus!</b>
		';
	}
}
?>