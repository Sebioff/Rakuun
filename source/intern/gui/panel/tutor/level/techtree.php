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

class Rakuun_Intern_GUI_Panel_Tutor_Level_Techtree extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return Router::get()->getCurrentModule() instanceof Rakuun_Intern_Module_Techtree;
	}
	
	public function getDescription() {
		$techtreeLink = new GUI_Control_Link('techtree', 'Techtree ("Produktion -&gt; Techtree")', App::get()->getInternModule()->getSubmodule('techtree')->getUrl());
		return '
			Mit Eisen und Beryllium als Rohstoffe wirst du allein nicht weiterkommen.
			Energie ist ein ebenso wichtiger Rohstoff. Bevor du ihn jedoch produzieren
			kannst, musst du Wassertechnik forschen. Hierfür benötigst du Forschungslabor 3.
			Welche Voraussetzungen du für bestimmte Gebäude oder Techniken benötigst,
			kannst du immer im '.$techtreeLink->render().' erfahren.<br />
			<b>Schaue dir jetzt den Techtree an</b>
		';
	}
}
?>