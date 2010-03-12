<?php

class Rakuun_Intern_Map_Path extends Scriptlet {
	public function display() {
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: image/gif');
		$image = imagecreatetruecolor(1000, 1000);
		$white = imagecolorallocate($image, 255, 255, 255);
		imagefilledrectangle($image, 0, 0, 1000, 1000, $white);
		imagesetthickness($image, 2);
		
		$enemyColor = imagecolorallocatealpha($image, 120, 0, 0, 30);
		$homeColor = imagecolorallocatealpha($image, 250, 250, 250, 30);
		
		foreach (Rakuun_User_Manager::getCurrentUser()->armies as $army) {
			$c = $army->targetX * $army->targetY;
			$c1 = pow($c, 2) % 151 + 50;
			$c2 = pow($c, 2) % 163 + 50;
			$c3 = pow($c, 2) % 147 + 50;
			$pathColor = imagecolorallocatealpha($image, $c1, $c2, $c3, 30);
			
			$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($army);
			$path = $pathCalculator->getPath($army->speed);
			$dotColor = $enemyColor;
			if ($army->targetX == Rakuun_User_Manager::getCurrentUser()->cityX &&$army->targetY == Rakuun_User_Manager::getCurrentUser()->cityY)
				$dotColor = $homeColor;
			imagefilledellipse($image, $army->positionX * 10 + 5, $army->positionY * 10 + 5, 10, 10, $dotColor);
			$pathNodeCount = count($path);
			for ($i = 0; $i < $pathNodeCount - 1; $i++) {
				$pathNodeA = $path[$i];
				$pathNodeB = $path[$i + 1];
				imageline($image, $pathNodeA['x'] * 10 + 5, $pathNodeA['y'] * 10 + 5, $pathNodeB['x'] * 10 + 5, $pathNodeB['y'] * 10 + 5, $pathColor);
			}
		}
		
		imagetruecolortopalette($image, false, 255);
		// for some reason, it won't work without this...
		$white = imagecolorat($image, 0, 0);
		imagecolortransparent($image, $white);
		imagegif($image);
		imagedestroy($image);
	}
}

?>