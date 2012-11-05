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

class Rakuun_Intern_GUI_Panel_Statistics_User_BuildingEvents extends GUI_Panel_PageView {
	public function __construct($name, $title = '') {
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['order'] = 'ID DESC';
		parent::__construct($name, Rakuun_DB_Containers::getLogBuildingsContainer()->getFilteredContainer($options), $title);
	}
	
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/events.tpl');
		
		$this->params->events = $this->getContainer()->select($this->getOptions());
	}
}

?>