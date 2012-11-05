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

class Rakuun_Intern_GUI_Panel_User_SitterSwitch extends GUI_Panel {
	private $sitting = null;
	
	public function __construct($name, Rakuun_DB_User $sitting) {
		parent::__construct($name);
		
		$this->sitting = $sitting;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/sitterswitch.tpl');
		$this->addClasses('rakuun_sitter_switchbox');
		
		$this->addPanel(new Rakuun_GUI_Control_UserLink('sittingname', $this->getSitting()));
		$this->addPanel($switchButton = new GUI_Control_SubmitButton('switch', 'Wechseln'));
		$switchButton->addClasses('rakuun_sitter_switchbutton');
		$this->addPanel($deleteButton = new GUI_Control_SubmitButton('delete', 'Löschen'));
		$deleteButton->setConfirmationMessage($this->getSitting()->nameUncolored.' wirklich nicht mehr sitten?');
		$deleteButton->addClasses('rakuun_sitter_deletebutton');
	}
	
	public function onDelete() {
		if ($this->hasErrors())
			return;

		$this->getSitting()->sitter = null;
		$this->getSitting()->save();
	}
	
	public function onSwitch() {
		if ($this->hasErrors())
			return;
		
		$originalUser = Rakuun_User_Manager::getCurrentUser();
		$_SESSION['userOriginal'] = $originalUser->getPK();
		$_SESSION['user'] = $this->getSitting()->getPK();
		$_SESSION['isSitting'] = true;
		$user = Rakuun_User_Manager::getCurrentUser();
		$user->lastActivity = time();
		if ($originalUser->lastBotVerification > $user->lastBotVerification)
			$user->lastBotVerification = $originalUser->lastBotVerification;
		Rakuun_User_Manager::update($user);
		// invalidation doesn't work here, redirect to current page
		$this->getModule()->redirect($this->getModule()->getUrl($this->getModule()->getParams()));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_DB_User
	 */
	public function getSitting() {
		return $this->sitting;
	}
}

?>