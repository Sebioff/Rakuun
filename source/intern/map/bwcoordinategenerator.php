<?php

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