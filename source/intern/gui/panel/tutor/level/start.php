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

class Rakuun_Intern_GUI_Panel_Tutor_Level_Start extends Rakuun_Intern_GUI_Panel_Tutor_Level {
	public function completed() {
		return true;
	}
	
	public function getDescription() {
		return '
			Hallo, ich bin Detlef, dein persönlicher Tutor für dieses Spiel.<br />
			Meine Aufgabe ist es, dir die ersten Schritte in der Welt Rakuuns zu zeigen.
			Zuerst werde ich dich durch die Spieloberfläche führen, bevor wir uns dem
			Aufbau deiner neuen Stadt widmen.<br />
			Wir befinden uns hier auf der Übersichtsseite.
			Hier findest du alle wichtigen Informationen auf einen Blick und kannst mit anderen
			Stadtoberhäuptern über die Shoutbox kommunizieren.<br />
			<b>Klicke auf "-&gt;" um fortzufahren!</b>
		';
	}
}
?>