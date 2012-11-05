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

class Rakuun_Intern_Module_Meta_Interaction extends Rakuun_Intern_Module_Meta_Common {
	public function init() {
		parent::init();
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/interaction.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('account', new Rakuun_Intern_GUI_Panel_Meta_Account('account'), 'Metakonto'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('deposit', new Rakuun_Intern_GUI_Panel_Meta_Account_Deposit('deposit'), 'Auf Metakonto einzahlen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('leave', new Rakuun_Intern_GUI_Panel_Meta_Leave('leave'), 'Meta verlassen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('allianceaccounts', new Rakuun_Intern_GUI_Panel_Meta_Account_AllianceAccounts('allianceaccounts'), 'Kontostände'));
	}
	
	public function checkPrivileges() {
		return Rakuun_Intern_Alliance_Security::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::GROUP_LEADERS);
	}
}
?>