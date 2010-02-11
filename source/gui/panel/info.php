<?php

class Rakuun_GUI_Panel_Info extends GUI_Panel_HoverInfo {
	public function __construct($name, $text, $hoverText) {
		parent::__construct($name, $text, $hoverText);
		
		$this->addClasses('rakuun_gui_infopanel');
	}
}

?>