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

class Rakuun_Intern_Module_Support extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->addSubmodule(new Rakuun_Intern_Module_Support_Display('display'));
	}
	
	public function init() {
		parent::init();

		$this->contentPanel->setTemplate(dirname(__FILE__).'/support.tpl');
		$this->setPageTitle('Supportcenter');
		
		if (!($supportType = $this->getParam('category')))
			$supportType = Rakuun_Intern_GUI_Panel_Support_Categories::CATEGORY_ANSWERED;
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Support_View('view', $supportType));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Support_Categories('categories', 'Nachrichtenkategorien'));
	}
	
	// OVERRIDES / IMPLEMENTS
	public function checkPrivileges() {
		return Rakuun_TeamSecurity::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Teamsecurity::PRIVILEGE_SUPPORT);
	}
}

?>