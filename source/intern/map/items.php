<?php

class Rakuun_Intern_Map_Items extends Scriptlet {
	public function display() {
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: image/gif');
		$image = imagecreate(Rakuun_Intern_GUI_Panel_Map::MAP_WIDTH * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE, Rakuun_Intern_GUI_Panel_Map::MAP_HEIGHT * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE);
		$black = imagecolorallocate($image, 0, 0, 0);
		imagecolortransparent($image, $black);
		
		// colors
		$colorCityNeutral = imagecreatefromgif(PROJECT_PATH.DS.'www/images/map_city_neutral.gif');
		$colorCityOwn = imagecreatefromgif(PROJECT_PATH.DS.'www/images/map_city_own.gif');
		$colorCityFriendly = imagecreatefromgif(PROJECT_PATH.DS.'www/images/map_city_friendly.gif');
		$colorCityAllied = imagecreatefromgif(PROJECT_PATH.DS.'www/images/map_city_allied.gif');
		$colorCityHostile = imagecreatefromgif(PROJECT_PATH.DS.'www/images/map_city_hostile.gif');
		$colorCityInactive = imagecreatefromgif(PROJECT_PATH.DS.'www/images/map_city_inactive.gif');
		$colorDatabase = imagecolorallocate($image, 255, 255, 0);
		
		if (Rakuun_User_Manager::getCurrentUser()) {
			if (Rakuun_User_Manager::getCurrentUser()->alliance) {
				$visibleDatabases = Rakuun_User_Specials_Database::getVisibleDatabasesForAlliance(Rakuun_User_Manager::getCurrentUser()->alliance);
				if (!empty($visibleDatabases)) {
					$images = Rakuun_User_Specials_Database::getDatabaseImages();
					$options = array();
					$options['conditions'][] = array('identifier IN ('.implode(', ', $visibleDatabases).')');
					foreach (Rakuun_DB_Containers::getDatabasesStartpositionsContainer()->select($options) as $databasePosition) {
						imagecopy($image, imagecreatefromgif(PROJECT_PATH.DS.'www/images/'.$images[$databasePosition->identifier].'.gif'), $databasePosition->positionX * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE - 1, $databasePosition->positionY * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE,  0, 0, 12, 10);
					}
				}
			}
			
			foreach (Rakuun_DB_Containers::getUserContainer()->select() as $user) {
				$color = $colorCityNeutral;
				if ($user->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK())
					$color = $colorCityOwn;
				elseif ($user->alliance && Rakuun_User_Manager::getCurrentUser()->alliance) {
					if ($user->alliance->getPK() == Rakuun_User_Manager::getCurrentUser()->alliance)
						$color = $colorCityAllied;
					$diplomacy = $user->alliance->getDiplomacy(Rakuun_User_Manager::getCurrentUser()->alliance);
					if ($diplomacy) {
						if ($diplomacy->type == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::RELATION_AUVB)
							$color = $colorCityAllied;
						if ($diplomacy->type == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::RELATION_WAR)
							$color = $colorCityHostile;
						if ($diplomacy->type == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::RELATION_NAP)
							$color = $colorCityFriendly;
					}
				}
				elseif ($user->isYimtay or $user->isLocked())
					$color = $colorCityInactive;
				imagecopy($image, $color, $user->cityX * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE, $user->cityY * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE,  0, 0, 10, 10);
			}
		}
		
		imagegif($image);
		imagedestroy($image);
	}
	
	private function drawItem($image, $x, $y, $color) {
		imagefilledrectangle($image, $x * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE, $y * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE, ($x + 1) * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE, ($y + 1) * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE, $color);
	}
}

?>