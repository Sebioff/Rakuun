<?php

class Rakuun_Intern_GUI_Panel_Map_ScrollButton_Left extends Rakuun_Intern_GUI_Panel_Map_ScrollButton {
	public function init() {
		parent::init();
		
		$this->setText('&lt;');
		$this->setScrollDeltaX(-3);
		$this->setAttribute('style', '
			background-color:#CCCCCC;
			float:left;
			height:'.($this->getMap()->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px;
			width:10px;
			line-height:'.($this->getMap()->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px;
		');
	}
}

?>