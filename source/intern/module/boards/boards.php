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

class Rakuun_Intern_Module_Boards extends Rakuun_Intern_Module {
	public function __construct($name) {
		parent::__construct($name);
		
		$user = Rakuun_User_Manager::getCurrentUser();
		if ($user) {
			$this->addSubmodule(new Rakuun_Intern_Module_Boards_Global('global'));
			if ($user->alliance) {
				$this->addSubmodule(new Rakuun_Intern_Module_Boards_Alliance('alliance'));
				if ($user->alliance->meta)
					$this->addSubmodule(new Rakuun_Intern_Module_Boards_Meta('meta'));
			}
			if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_BACKENDACCESS))
				$this->addSubmodule(new Rakuun_Intern_Module_Boards_Admin('admin'));
		}
	}
	
	public function init() {
		parent::init();
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/boards.tpl');
		$this->setPageTitle('Übersicht');
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Board_Overview('overview'));
	}
}
?>