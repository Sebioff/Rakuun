<?php

class Rakuun_Intern_Map_AStar {
	private $bitMap;
	private $map;
	private $movementCosts = 0;
	private $unitTypes = 0;
	private static $height = 100;
	private static $width = 100;

	public function __construct($movementCosts, $unitTypes) {
		$this->bitMap = imagecreatefrompng(PROJECT_PATH.'/www/images/map.png');
		$this->movementCosts = $movementCosts;
		$this->unitTypes = $unitTypes;
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
		$closedNodes[] = $expandedNode;
		
		$reachableNodes = array();
		if ($expandedNode['x'] - 1 >= 0)
			$reachableNodes[] = &$this->getMapNode($expandedNode['x'] - 1, $expandedNode['y']);
		if ($expandedNode['x'] + 1 < self::$width)
			$reachableNodes[] = &$this->getMapNode($expandedNode['x'] + 1, $expandedNode['y']);
		if ($expandedNode['y'] - 1 >= 0)
			$reachableNodes[] = &$this->getMapNode($expandedNode['x'], $expandedNode['y'] - 1);
		if ($expandedNode['y'] + 1 < self::$height)
			$reachableNodes[] = &$this->getMapNode($expandedNode['x'], $expandedNode['y'] + 1);
		
		// diagonal
//		if ($expandedNode['x'] - 1 >= 0 && $expandedNode['y'] - 1 >= 0)
//			$reachableNodes[] = &self::$map[$expandedNode['x'] - 1][$expandedNode['y'] - 1];
//		if ($expandedNode['x'] + 1 < self::$width && $expandedNode['y'] - 1 >= 0)
//			$reachableNodes[] = &self::$map[$expandedNode['x'] + 1][$expandedNode['y'] - 1];
//		if ($expandedNode['x'] - 1 >= 0 && $expandedNode['y'] + 1 < self::$height)
//			$reachableNodes[] = &self::$map[$expandedNode['x'] - 1][$expandedNode['y'] + 1];
//		if ($expandedNode['x'] + 1 < self::$width && $expandedNode['y'] + 1 < self::$height)
//			$reachableNodes[] = &self::$map[$expandedNode['x'] + 1][$expandedNode['y'] + 1];
			
		foreach ($reachableNodes as &$reachableNode) {
			$deltaX = abs($reachableNode['x'] - $targetNode['x']);
			$deltaY = abs($reachableNode['y'] - $targetNode['y']);
			
			if ((!$reachableNode['walkable'] && $this->unitTypes != Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT) || $reachableNode['expanded']) {
				continue;
			}
			
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
		array_unshift($path, $pathNode);

		if ($pathNode['x'] != $startNode['x'] || $pathNode['y'] != $startNode['y'])
			$this->reconstructPath($pathNode['parentNode'], $startNode, $path);
		
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
			$walkable = (imagecolorat($this->bitMap, $x, $y) == 0x000000);
			$this->map[$x][$y] = array('x' => $x, 'y' => $y, 'walkable' => $walkable, 'costs' => $this->movementCosts, 'f' => 0, 'g' => 0, 'h' => 0, 'open' => false, 'expanded' => false);
		}
		
		return $this->map[$x][$y];
	}
	
	public function getMovementCosts(array $fromNode, array $toNode) {
		return abs($toNode['x'] - $fromNode['x']) + abs($toNode['y'] - $fromNode['y']) + $toNode['costs'] / RAKUUN_SPEED_UNITMOVEMENT;
	}
}

?>