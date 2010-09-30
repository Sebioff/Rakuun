<?php

class Rakuun_Intern_GUI_Panel_Map_ScrollButton extends GUI_Panel_Text {
	const SCROLL_SPEED = 20;
	
	private $scrollDeltaX = 0;
	private $scrollDeltaY = 0;
	private $map = null;
	
	public function __construct($name, $text, Rakuun_Intern_GUI_Panel_Map $map, $title = '') {
		parent::__construct($name, $text, $title);
		$this->map = $map;
	}
	
	public function init() {
		parent::init();
		
		$this->setAttribute('style', '
			background-color:#555555;
			cursor:pointer;
			float:left;
			height:'.$this->getMap()->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px;
			line-height:'.$this->getMap()->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px;
		');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->addJS(
			sprintf(
				'
					$("#%s").mousedown(function() {
						scroll(%2$d, %3$d);
						scrollTimer = setInterval(function(){scroll(%2$d, %3$d);}, %4$d);
						return false;
					}).mouseup(function() {
						clearInterval(scrollTimer);
					}).mouseout(function() {
						clearInterval(scrollTimer);
					});
				',
				$this->getID(), $this->scrollDeltaX, $this->scrollDeltaY, self::SCROLL_SPEED
			)
		);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function setScrollDeltaX($scrollDeltaX) {
		$this->scrollDeltaX = $scrollDeltaX;
	}
	
	public function setScrollDeltaY($scrollDeltaY) {
		$this->scrollDeltaY = $scrollDeltaY;
	}
	
	/**
	 * @return Rakuun_Intern_GUI_Panel_Map
	 */
	public function getMap() {
		return $this->map;
	}
}

?>