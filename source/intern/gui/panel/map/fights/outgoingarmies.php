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

class Rakuun_Intern_GUI_Panel_Map_Fights_OutgoingArmies extends GUI_Panel {
	private $armiesPanels = array();
	
	public function init() {
		parent::init();
		
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['order'] = 'target_time ASC';
		foreach (Rakuun_DB_Containers::getArmiesContainer()->select($options) as $army) {
			$this->addPanel($armyPanel = new Rakuun_Intern_GUI_Panel_Map_Fights_OutgoingArmy('army_'.$army->getPK(), $army));
			$this->armiesPanels[] = $armyPanel;
		}
		
		$this->setTemplate(dirname(__FILE__).'/outgoingarmies.tpl');
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getArmiesPanels() {
		return $this->armiesPanels;
	}
}

?>