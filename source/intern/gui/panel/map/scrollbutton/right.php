<?php

class Rakuun_Intern_GUI_Panel_Map_ScrollButton_Right extends Rakuun_Intern_GUI_Panel_Map_ScrollButton {
	public function init() {
		parent::init();
		
		$this->setText('&gt;');
		$this->setScrollDeltaX(3);
		$this->setAttribute('style', '
			background-color:#555555;
			cursor:pointer;
			margin-right:10px;
			float:left;
			height:'.($this->getMap()->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px;
			width:10px;
			line-height:'.($this->getMap()->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px;
		');
	}
}

?>