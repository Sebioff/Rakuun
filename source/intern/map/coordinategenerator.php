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

class Rakuun_Intern_Map_CoordinateGenerator {
	protected $bitMap;
	protected $map;

	public function __construct() {
		$this->bitMap = imagecreatefrompng(PROJECT_PATH.'/www/images/map.png');
	}
	
	public function getRandomFreeCoordinate() {
		do {
			$freePosition = false;
			$x = rand(0, Rakuun_Intern_GUI_Panel_Map::MAP_WIDTH - 1);
			$y = rand(0, Rakuun_Intern_GUI_Panel_Map::MAP_HEIGHT - 1);
			$mapNode = &$this->getMapNode($x, $y);
			$freePosition = $mapNode['walkable'];
			if ($freePosition) {
				$options = array();
				$options['conditions'][] = array('city_x = ?', $x);
				$options['conditions'][] = array('city_y = ?', $y);
				$freePosition = (Rakuun_DB_Containers::getUserContainer()->selectFirst($options) === null);
			}
			if ($freePosition) {
				$options = array();
				$options['conditions'][] = array('position_x = ?', $x);
				$options['conditions'][] = array('position_y = ?', $y);
				$freePosition = (Rakuun_DB_Containers::getDatabasesStartpositionsContainer()->selectFirst($options) === null);
			}
		} while(!$freePosition);
		
		return array($x, $y);
	}
	
	protected function &getMapNode($x, $y) {
		if (!isset($this->map[$x][$y])) {
			$walkable = (imagecolorat($this->bitMap, $x, $y) == 0x000000);
			$this->map[$x][$y] = array('x' => $x, 'y' => $y, 'walkable' => $walkable);
		}
		
		return $this->map[$x][$y];
	}
}

?>