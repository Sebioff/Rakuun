<?php

class Rakuun_Intern_Map_Path extends Scriptlet {
	public function display() {
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: image/gif');
		$image = imagecreate(1000, 1000);
		$black = imagecolorallocate($image, 0, 0, 0);
		imagecolortransparent($image, $black);
		$pathColor = imagecolorallocate($image, 255, 255, 255);
		
		$style = Array(
                $pathColor,
                $pathColor,
                $pathColor,
                $pathColor,
                IMG_COLOR_TRANSPARENT,
                IMG_COLOR_TRANSPARENT,
                IMG_COLOR_TRANSPARENT,
                IMG_COLOR_TRANSPARENT
                );

		imagesetstyle($image, $style);
		
		foreach (Rakuun_User_Manager::getCurrentUser()->armies as $army) {
			$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($army);
			$path = $pathCalculator->getPath($army->speed);
			imagefilledellipse($image, $army->positionX * 10 + 5, $army->positionY * 10 + 5, 10, 10, $pathColor);
			$pathNodeCount = count($path);
			for ($i = 0; $i < $pathNodeCount - 1; $i++) {
				$pathNodeA = $path[$i];
				$pathNodeB = $path[$i + 1];
				imageline($image, $pathNodeA['x'] * 10 + 5, $pathNodeA['y'] * 10 + 5, $pathNodeB['x'] * 10 + 5, $pathNodeB['y'] * 10 + 5, IMG_COLOR_STYLED);
			}
		}
		
		imagegif($image);
		imagedestroy($image);
	}
}

?>