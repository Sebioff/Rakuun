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

class Rakuun_Intern_Module_Alliance_Interact extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/interact.tpl');
		if (Rakuun_Intern_Mode::getCurrentMode()->allowLeaveAlliances()) {
			$this->contentPanel->addPanel($leaveBox = new Rakuun_GUI_Panel_Box('leavebox', new Rakuun_Intern_GUI_Panel_Alliance_Leave('leave'), 'Allianz verlassen'));
			$leaveBox->addClasses('rakuun_box_alliance_leave');
		}
		$this->contentPanel->addPanel($depositBox = new Rakuun_GUI_Panel_Box('depositbox', new Rakuun_Intern_GUI_Panel_Alliance_Account_Deposit('deposit'), 'Auf Allianzkonto einzahlen'));
		$depositBox->addClasses('rakuun_box_alliance_deposit');
		$this->contentPanel->addPanel($accountBox = new Rakuun_GUI_Panel_Box('accountbox', new Rakuun_Intern_GUI_Panel_Alliance_Account('account'), 'Allianzkonto'));
		$accountBox->addClasses('rakuun_box_alliance_account');
	}

	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return (isset($this->getUser()->alliance));
	}
}
?>