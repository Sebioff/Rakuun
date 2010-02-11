<?php

class Rakuun_Intern_Map_Path extends Scriptlet {
	public function display() {
		header('Content-type: image/gif');
		$image = imagecreate(1000, 1000);
		$black = imagecolorallocate($image, 0, 0, 0);
		imagecolortransparent($image, $black);
		$pathColor = imagecolorallocate($image, 100, 0, 0);
		
		foreach (Rakuun_User_Manager::getCurrentUser()->armies as $army) {
			$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($army);
			$path = $pathCalculator->getPath($army->speed);
			foreach ($path as $pathNode) {
				imagefilledrectangle($image, $pathNode['x'] * 10, $pathNode['y'] * 10, $pathNode['x'] * 10 + 10, $pathNode['y'] * 10 + 10, $pathColor);
			}
		}
		
		imagegif($image);
		imagedestroy($image);
	}
}

?>