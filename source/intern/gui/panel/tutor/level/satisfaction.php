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

class Rakuun_Intern_GUI_Panel_Tutor_Level_Satisfaction extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return ((Rakuun_Intern_Production_Influences::getPeopleSatisfactionRate() * 100) - 100) >= 10;
	}
	
	public function getDescription() {
		return '
			Die Zufriedenheit deiner Bürger beeinflusst die Produktion der Ressourcen.
			Je zufriedener deine Leute sind, desto mehr produzieren sie auch.
			Wenn dich deine Bürger verehren hast du die maximale Zufriedenheit deiner Leute hergestellt.
			Sie produzieren dann 10% mehr Ressourcen als normal.
			Um die Zufriedenheit deiner Bürger zu steigern musst du Freizeitparks bauen.
			<br /><b>Baue nun dein Freizeitpark so aus, bis dich deine Leute verehren.</b>
			 
		';
	}
}

?>