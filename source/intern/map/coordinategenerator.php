<?php

class Rakuun_Intern_Map_CoordinateGenerator {
	private $bitMap;
	private $map;
	private static $height = 100;
	private static $width = 100;

	public function __construct() {
		$this->bitMap = imagecreatefrompng(PROJECT_PATH.'/www/images/map.png');
	}
	
	public function getRandomFreeCoordinate() {
		do {
			$freePosition = false;
			$x = rand(0, self::$width - 1);
			$y = rand(0, self::$height - 1);
			$mapNode = &$this->getMapNode($x, $y);
			$freePosition = $mapNode['walkable'];
			if ($freePosition) {
				$options = array();
				$options['conditions'][] = array('city_x = ?', $x);
				$options['conditions'][] = array('city_y = ?', $y);
				$freePosition = (Rakuun_DB_Containers::getUserContainer()->selectFirst($options) === null);
			}
		} while(!$freePosition);
		
		return array($x, $y);
	}
	
	private function &getMapNode($x, $y) {
		if (!isset($this->map[$x][$y])) {
			$walkable = (imagecolorat($this->bitMap, $x, $y) == 0x000000);
			$this->map[$x][$y] = array('x' => $x, 'y' => $y, 'walkable' => $walkable);
		}
		
		return $this->map[$x][$y];
	}
}

?>