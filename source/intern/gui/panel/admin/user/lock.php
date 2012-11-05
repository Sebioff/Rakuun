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
 * Panel to lock users
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_User_Lock extends GUI_Panel {
	// user to lock
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null) {
		parent::__construct($name);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/lock.tpl');

		$this->addPanel($user = new Rakuun_GUI_Control_UserSelect('lockuser', $this->user, 'User'));
		$user->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel($timeban = new GUI_Control_Digitbox('timeban', 0, 'Zeit in Stunden (0=dauerhafte Sperre'));
		$this->addPanel(new GUI_Control_SubmitButton('lock', 'User sperren'));
	}
	
	public function onLock() {
		$user = $this->lockuser->getUser();
		$timeban = $this->timeban->getValue();
		
		if (Rakuun_GameSecurity::get()->isInGroup($user, Rakuun_GameSecurity::GROUP_LOCKED)) {
			$this->addError('Spieler ist bereits gesperrt');
		}
		
		if ($this->hasErrors())
			return;
		
		Rakuun_User_Manager::lock($user, $timeban);
	}
}

?>