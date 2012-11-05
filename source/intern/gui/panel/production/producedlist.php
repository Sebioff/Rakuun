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

class Rakuun_Intern_GUI_Panel_Production_ProducedList extends Rakuun_GUI_Panel_Box_Collapsible {
	private $user = null;
	private $producedItems = array();
	
	public function __construct($name, array $producedItems, $user = null, $title = '') {
		parent::__construct($name, null, $title);
		
		$this->producedItems = $producedItems;
		
		if (!$user)
			$user = Rakuun_User_Manager::getCurrentUser();
		$this->user = $user;
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/producedlist.tpl');
		$this->contentPanel->params->producedItems = $this->producedItems;
	}
}

?>