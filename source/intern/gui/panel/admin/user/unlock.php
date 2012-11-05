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
 * Panel to Unlock User
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_User_Unlock extends GUI_Panel {
	public function __construct($name, Rakuun_DB_User $user = null) {
		parent::__construct($name);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/unlock.tpl');
		
		// get only users of the group "LOCKED" into the DropDownBox
		$lockedusers = array();
		foreach (Rakuun_GameSecurity::get()->getGroupUsers(Rakuun_GameSecurity::GROUP_LOCKED) as $lockeduser)
			$lockedusers[$lockeduser->getPK()] = $lockeduser->nameUncolored;
		$this->addPanel(new GUI_Control_DropDownBox('lockedusers', $lockedusers));
		
		$this->addPanel(new GUI_Control_SubmitButton('unlock', 'User entsperren'));
	}
	
	public function onUnlock() {
		$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($this->lockedusers->getKey());
		if (!$user) {
			$this->addError('kein Spieler ausgewählt');
		}
		
		if ($this->hasErrors())
			return;
		
		Rakuun_User_Manager::unlock($user);
	}
}

?>