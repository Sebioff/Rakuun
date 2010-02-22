<?php

class Rakuun_Intern_Map_Items extends Scriptlet {
	public function display() {
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: image/gif');
		$image = imagecreate(1000, 1000);
		$black = imagecolorallocate($image, 0, 0, 0);
		imagecolortransparent($image, $black);
		
		// colors
		$colorCityNeutral = imagecolorallocate($image, 139, 139, 139);
		$colorCityOwn = imagecolorallocate($image, 255, 255, 255);
		$colorCityFriendly = imagecolorallocate($image, 255, 191, 0);
		$colorCityAllied = imagecolorallocate($image, 0, 128, 0);
		$colorCityHostile = imagecolorallocate($image, 225, 0, 0);
		$colorDatabase = imagecolorallocate($image, 255, 255, 0);
		
		if (Rakuun_User_Manager::getCurrentUser()->alliance && Rakuun_User_Manager::getCurrentUser()->alliance->buildings->databaseDetector > 0) {
			$visibleDatabases = Rakuun_User_Specials_Database::getVisibleDatabasesForAlliance(Rakuun_User_Manager::getCurrentUser()->alliance);
			if (!empty($visibleDatabases)) {
				$options = array();
				$options['conditions'][] = array('identifier IN ('.implode(', ', $visibleDatabases).')');
				foreach (Rakuun_DB_Containers::getDatabasesStartpositionsContainer()->select($options) as $databasePosition) {
					$this->drawItem($image, $databasePosition->positionX, $databasePosition->positionY, $colorDatabase);
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
			$this->drawItem($image, $user->cityX, $user->cityY, $color);
		}
		
		imagegif($image);
		imagedestroy($image);
	}
	
	private function drawItem($image, $x, $y, $color) {
		imagefilledrectangle($image, $x * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE, $y * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE, ($x + 1) * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE, ($y + 1) * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE, $color);
	}
}

?>