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
 * Create a Link to Trade with a User
 * make sure, that the User has the Abilities to Trade with using this Link
 * @author dr.dent
 */
class Rakuun_GUI_Control_TradeLink extends GUI_Control_Link {
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		if ($user === null) {
			parent::__construct($name, Rakuun_DB_User::DELETED_USER_NAME, '#', $title);
		}
		else {
			if (App::get()->getInternModule()->hasSubmodule('trade'))
				$url = App::get()->getInternModule()->getSubmodule('trade')->getURL(array('user' => $user->id));
			else
				$url = '#';
			parent::__construct($name, 'mit '.$user->name.' Handeln', $url, $title);
		}
	}
}

?>