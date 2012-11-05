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

class Rakuun_GUI_Control_MultiUserSelect extends Rakuun_GUI_Control_UserSelect {
	protected function generateJS() {
		return sprintf('$("#%s").autocomplete("%s", {width: 260, autoFill: true, multiple: true, max: 10});', $this->getID(), App::get()->getUserSelectScriptletModule()->getURL());
	}
	
	protected function validation() {
		if ($this->getValue()) {
			$recipients = explode(',', $this->getValue());
			foreach ($recipients as $recipient) {
				$recipient = trim($recipient);
				if (strlen($recipient) > 0
					&& !Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($recipient)
				)
					return 'Spieler existiert nicht: '.$recipient;
			}
		}
	}
	
	/**
	 * @return Rakuun_DB_User
	 */
	public function getUser() {
		$users = array();
		
		if ($this->getValue()) {
			$recipients = explode(',', $this->getValue());
			$recipients = array_map('trim', $recipients);
			$recipients = array_unique($recipients);
			foreach ($recipients as $recipient) {
				if ($user = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($recipient))
					$users[] = $user;
			}
		}
		return $users;
	}
}

?>