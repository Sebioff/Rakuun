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

// TODO implement correctly
class Rakuun_Intern_Map_BWCoordinateGenerator extends Rakuun_Intern_Map_CoordinateGenerator {
	public function __construct() {
		$this->bitMap = imagecreatefrompng(PROJECT_PATH.'/www/images/map_bw.png');
	}
	
	public function getRandomFreeCoordinate() {
		do {
			$freePosition = false;
			$options = array();
			$options['conditions'][] = array('city_x <= 58');
			$blackCount = Rakuun_DB_Containers::getUserContainer()->count($options);
			$options = array();
			$options['conditions'][] = array('city_x >= 64');
			$whiteCount = Rakuun_DB_Containers::getUserContainer()->count($options);
			if ($blackCount < $whiteCount)
				$x = rand(0, 58);
			else
				$x = rand(64, Rakuun_Intern_GUI_Panel_Map::MAP_WIDTH - 1);
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
}

?>