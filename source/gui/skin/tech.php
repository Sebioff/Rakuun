<?php

class Rakuun_GUI_Skin_Tech extends Rakuun_GUI_Skin {
	public function __construct() {
		parent::__construct('Tech', 'tech');
	}
	
	public function onUseSkin() {
		GUI_Panel_Plot::$defaultTheme = 'Rakuun_GUI_Skin_JPGraph_TechTheme';
	}
}

?>