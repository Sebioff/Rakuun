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

class Rakuun_Intern_GUI_Panel_Tutor_Level_Alliance extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user->alliance != null);
	}
	
	public function getDescription() {
		if ($module = App::get()->getInternModule()->getSubmodule('alliance'))
			$allianceLink = new GUI_Control_Link('alliance', 'Allianz', $module->getUrl());
		else
			$allianceLink = new GUI_Panel_Text('alliance', 'Allianz (nicht verfügbar)');
		return '
			Die Allianz ist ein wesentlicher Bestandteil des Spiels. Ohne Allianz kann man das Spiel nicht gewinnen.
			Hier wird dir geholfen und der Zusammenhalt gestärkt. Eine Allianz bietet dir zudem einige Vorteile wie z.B.:
			<ul>
				<li>du kannst deine Ressourcen in der Allianzkasse sparen und dir oder anderen Spielern damit unterstützen</li>
				<li>Ressourcen und Armeen deiner Allianzmitglieder einsehen</li>
				<li>Bündnisse mit anderen Allianzen schließen und damit Verbündete gewinnen oder</li>
				<li>anderen Allianzen den Krieg erklären um an die Herrschaft Rakuuns zu gelangen</li>
			</ul>
			<b>Trete daher nun einer '.$allianceLink->render().' deiner Wahl bei oder gründe deine eigene!</b>
		';
	}
}

?>