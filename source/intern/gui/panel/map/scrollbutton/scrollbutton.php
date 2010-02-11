<?php

class Rakuun_Intern_GUI_Panel_Map_ScrollButton extends GUI_Panel_Text {
	const SCROLL_SPEED = 20;
	
	private $scrollDeltaX = 0;
	private $scrollDeltaY = 0;
	
	public function init() {
		parent::init();
		
		$this->setAttribute('style', '
			background-color:#CCCCCC;
			float:left;
			height:600px;
			line-height:600px;
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
	
	public function setScrollDeltaX($scrollDeltaX) {
		$this->scrollDeltaX = $scrollDeltaX;
	}
	
	public function setScrollDeltaY($scrollDeltaY) {
		$this->scrollDeltaY = $scrollDeltaY;
	}
}

?>