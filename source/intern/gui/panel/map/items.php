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

class Rakuun_Intern_GUI_Panel_Map_Items extends GUI_Panel {
	private $map = null;
	private $scrollItems = array();
	
	public function __construct($name, Rakuun_Intern_GUI_Panel_Map $map) {
		parent::__construct($name);
		
		$this->map = $map;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/items.tpl');
		if (Rakuun_User_Manager::getCurrentUser()->alliance) {
			$visibleDatabases = Rakuun_User_Specials_Database::getVisibleDatabasesForAlliance(Rakuun_User_Manager::getCurrentUser()->alliance);
			if (!empty($visibleDatabases)) {
				$options = array();
				$options['conditions'][] = array('identifier IN ('.implode(', ', $visibleDatabases).')');
				foreach (Rakuun_DB_Containers::getDatabasesStartpositionsContainer()->select($options) as $databasePosition) {
					$this->addPanel($databasePanel = new Rakuun_Intern_GUI_Panel_Map_Descriptions_Database($this->map, $databasePosition->identifier, $databasePosition->positionX, $databasePosition->positionY));
					$this->scrollItems[] = $databasePanel;
				}
			}
		}
		
		foreach (Rakuun_DB_Containers::getUserContainer()->select() as $city) {
			$this->addPanel($cityPanel = new Rakuun_Intern_GUI_Panel_Map_Descriptions_City($city, $this->map));
			$this->scrollItems[] = $cityPanel;
		}
		
		foreach (Rakuun_User_Manager::getCurrentUser()->armies as $army) {
			$this->addPanel($armyPanel = new Rakuun_Intern_GUI_Panel_Map_Descriptions_Army($army, $this->map));
			$this->scrollItems[] = $armyPanel;
		}
		
		$this->addClasses('scroll_item');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$style = array(
			'height:'.Rakuun_Intern_GUI_Panel_Map::MAP_HEIGHT * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px',
			'width:'.Rakuun_Intern_GUI_Panel_Map::MAP_WIDTH * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px'
		);
		$this->setAttribute('src', App::get()->getMapItemsModule()->getURL().'?cb='.time());
		$this->setAttribute('style', implode(';', $style));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getScrollItems() {
		return $this->scrollItems;
	}
	
	public function getMap() {
		return $this->map;
	}
}

?>