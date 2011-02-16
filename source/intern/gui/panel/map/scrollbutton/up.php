<?php

class Rakuun_Intern_GUI_Panel_Map_ScrollButton_Up extends Rakuun_Intern_GUI_Panel_Map_ScrollButton {
	public function init() {
		parent::init();
		
		$this->setScrollDeltaY(-3);
		$this->setAttribute('style', '
			background:#555555 url(\''.Router::get()->getStaticRoute('images', 'tech/map_scroll_up.gif').'\') no-repeat center 1px;
			cursor:pointer;
			display:block;
			height:13px;
			width:'.($this->getMap()->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE + 26).'px;
			text-align:center;
		');
	}
}

?>