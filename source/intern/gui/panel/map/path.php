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

class Rakuun_Intern_GUI_Panel_Map_Path extends GUI_Panel {
	private $map = null;
	
	public function __construct($name, Rakuun_Intern_GUI_Panel_Map $map) {
		parent::__construct($name);
		
		$this->map = $map;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/path.tpl');
		$this->addClasses('scroll_bg');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$style = array(
			'position:absolute',
			'height:'.$this->map->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px',
			'width:'.$this->map->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px',
			'background:transparent url('.App::get()->getMapPathModule()->getURL().'?cb='.time().') '.(-$this->map->getViewRectX() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px '.(-$this->map->getViewRectY() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px'
		);
		$this->setAttribute('style', implode(';', $style));
	}
}

?>