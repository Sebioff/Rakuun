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

class Rakuun_Intern_Module_Alliance_Statistics extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();

		$alliance = $this->getUser()->alliance;
		$this->setPageTitle('Statistiken - ['.$alliance->tag.'] '.$alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/statistics.tpl');
		
		$user = Rakuun_User_Manager::getCurrentUser();
		if (Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_STATISTICS)) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('ressources', new Rakuun_Intern_GUI_Panel_Alliance_Statistic_Ressources('ressources'), 'Rohstoffübersicht'));
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('army', new Rakuun_Intern_GUI_Panel_Alliance_Statistic_Army('army'), 'Armeeübersicht'));
		}
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_STATISTICS);
	}
}

?>