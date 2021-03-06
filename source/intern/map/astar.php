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

/**
 * TODO Use SplMinHeap with PHP 5.3 for the open list, should be way faster
 *
 */
class Rakuun_Intern_Map_AStar {
	private $bitMap;
	private $map;
	private $movementCosts = 0;
	private $canAllMoveOverWater = false;

	public function __construct($movementCosts, $canAllMoveOverWater) {
		$this->bitMap = Rakuun_Intern_Mode::getCurrentMode()->getBitMapImage();
		$this->movementCosts = $movementCosts;
		$this->canAllMoveOverWater = $canAllMoveOverWater;
	}
	
	public function run($startX, $startY, $endX, $endY) {
		$path = array();
		
		$startNode = &$this->getMapNode($startX, $startY);
		$targetNode = &$this->getMapNode($endX, $endY);

		$openNodes = array();
		$closedNodes = array();
		if ($targetNode['walkable'])
			$openNodes[] = &$startNode;
		while (!empty($openNodes)) {
			$i = $this->linearSearch($openNodes);
			$bestNode = &$openNodes[$i];
			array_splice($openNodes, $i, 1);
			$bestNode['open'] = false;
			if ($bestNode['x'] == $targetNode['x'] && $bestNode['y'] == $targetNode['y']) {
				$path = $this->reconstructPath($bestNode, $startNode);
				break;
			}
			$this->expandNode($bestNode, $targetNode, $openNodes, $closedNodes);
		}

		
		return $path;
	}
	
	private function expandNode(&$expandedNode, &$targetNode, &$openNodes, &$closedNodes) {
		$expandedNode['expanded'] = true;
		$closedNodes[] = &$expandedNode;
		
		$reachableNodes = array();
		if ($expandedNode['x'] - 1 >= 0)
			$reachableNodes[] = &$this->getMapNode($expandedNode['x'] - 1, $expandedNode['y']);
		if ($expandedNode['x'] + 1 < Rakuun_Intern_GUI_Panel_Map::MAP_WIDTH)
			$reachableNodes[] = &$this->getMapNode($expandedNode['x'] + 1, $expandedNode['y']);
		if ($expandedNode['y'] - 1 >= 0)
			$reachableNodes[] = &$this->getMapNode($expandedNode['x'], $expandedNode['y'] - 1);
		if ($expandedNode['y'] + 1 < Rakuun_Intern_GUI_Panel_Map::MAP_HEIGHT)
			$reachableNodes[] = &$this->getMapNode($expandedNode['x'], $expandedNode['y'] + 1);
		
		// diagonal
//		if ($expandedNode['x'] - 1 >= 0 && $expandedNode['y'] - 1 >= 0)
//			$reachableNodes[] = &self::$map[$expandedNode['x'] - 1][$expandedNode['y'] - 1];
//		if ($expandedNode['x'] + 1 < self::$width && $expandedNode['y'] - 1 >= 0)
//			$reachableNodes[] = &self::$map[$expandedNode['x'] + 1][$expandedNode['y'] - 1];
//		if ($expandedNode['x'] - 1 >= 0 && $expandedNode['y'] + 1 < Rakuun_Intern_GUI_Panel_Map::MAP_HEIGHT)
//			$reachableNodes[] = &self::$map[$expandedNode['x'] - 1][$expandedNode['y'] + 1];
//		if ($expandedNode['x'] + 1 < self::$width && $expandedNode['y'] + 1 < Rakuun_Intern_GUI_Panel_Map::MAP_HEIGHT)
//			$reachableNodes[] = &self::$map[$expandedNode['x'] + 1][$expandedNode['y'] + 1];
			
		foreach ($reachableNodes as &$reachableNode) {
			if ((!$reachableNode['walkable'] && !$this->canAllMoveOverWater) || $reachableNode['expanded']) {
				continue;
			}
			
			$deltaX = abs($reachableNode['x'] - $targetNode['x']);
			$deltaY = abs($reachableNode['y'] - $targetNode['y']);
			
			$g = $this->getMovementCosts($expandedNode, $reachableNode) + $expandedNode['g'];
			
			$h = sqrt($deltaX * $deltaX + $deltaY * $deltaY) * ($this->movementCosts + 1) / RAKUUN_SPEED_UNITMOVEMENT;
			$f = $g + $h;

			if ($reachableNode['open'] && $f > $reachableNode['f'])
				continue;
				
			$reachableNode['parentNode'] = &$expandedNode;
			$reachableNode['g'] = $g;
			$reachableNode['f'] = $f;
			
			if (!$reachableNode['open']) {
				$reachableNode['open'] = true;
				$openNodes[] = &$reachableNode;
			}
		}
	}
	
	private function reconstructPath(&$pathNode, &$startNode, &$path = array()) {
		do {
			array_unshift($path, $pathNode);
			$prevNode = &$pathNode;
			$pathNode = &$pathNode['parentNode'];
		}
		while ($prevNode['x'] != $startNode['x'] || $prevNode['y'] != $startNode['y']);

		return $path;
	}
	
	public function linearSearch(&$array) {
		$minI = 0;
		$minF = $array[0]['f'];
		$i = 0;
		foreach ($array as &$value) {
			if ($value['f'] < $minF) {
				$minI = $i;
				$minF = $value['f'];
			}
			$i++;
		}
		
		return $minI;
	}
	
	public function &getMapNode($x, $y) {
		if (!isset($this->map[$x][$y])) {
			$walkable = $x < Rakuun_Intern_GUI_Panel_Map::MAP_WIDTH && $y < Rakuun_Intern_GUI_Panel_Map::MAP_HEIGHT
						&& (imagecolorat($this->bitMap, $x, $y) == 0x000000);
			$this->map[$x][$y] = array('x' => $x, 'y' => $y, 'walkable' => $walkable, 'costs' => $this->movementCosts, 'f' => 0, 'g' => 0, 'h' => 0, 'open' => false, 'expanded' => false);
		}
		
		return $this->map[$x][$y];
	}
	
	public function getMovementCosts(array $fromNode, array $toNode) {
		return round(abs($toNode['x'] - $fromNode['x']) + abs($toNode['y'] - $fromNode['y']) + $toNode['costs'] / RAKUUN_SPEED_UNITMOVEMENT);
	}
}

?>