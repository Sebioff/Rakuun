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

class Rakuun_Intern_Module_Alliance_Account extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();

		$alliance = $this->getUser()->alliance;
		$this->setPageTitle('Allianzkasse - ['.$alliance->tag.'] '.$alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/account.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('account', new Rakuun_Intern_GUI_Panel_Alliance_Account('overview'), 'Allianzkasse'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('payout', new Rakuun_Intern_GUI_Panel_Alliance_Account_Payout('payout'), 'Vom Allianzkonto auszahlen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('logview', new Rakuun_Intern_GUI_Panel_Alliance_Account_LogView('logview'), 'Kontobewegungen einsehen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('useraccounts', new Rakuun_Intern_GUI_Panel_Alliance_Account_UserAccounts('useraccounts'), 'Kontostände'));
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_RESSOURCES);
	}
}

?>