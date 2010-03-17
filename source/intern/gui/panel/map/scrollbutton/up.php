<?php

class Rakuun_Intern_GUI_Panel_Map_ScrollButton_Up extends Rakuun_Intern_GUI_Panel_Map_ScrollButton {
	public function init() {
		parent::init();
		
		$this->setText('^');
		$this->setScrollDeltaY(-3);
		$this->setAttribute('style', '
			background-color:#CCCCCC;
			display:block;
			height:10px;
			width:'.($this->getMap()->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE + 20).'px;
			text-align:center;
		');
	}
}

?>