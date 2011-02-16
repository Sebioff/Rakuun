<?php

class Rakuun_Intern_GUI_Panel_Map_ScrollButton_Right extends Rakuun_Intern_GUI_Panel_Map_ScrollButton {
	public function init() {
		parent::init();
		
		$this->setScrollDeltaX(3);
		$this->setAttribute('style', '
			background:#555555 url(\''.Router::get()->getStaticRoute('images', 'tech/map_scroll_right.gif').'\') no-repeat left center;
			cursor:pointer;
			margin-right:10px;
			float:left;
			height:'.($this->getMap()->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px;
			width:13px;
			line-height:'.($this->getMap()->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px;
		');
	}
}

?>