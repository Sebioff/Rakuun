<?php

class Rakuun_Intern_GUI_Panel_Map_ScrollButton_Left extends Rakuun_Intern_GUI_Panel_Map_ScrollButton {
	public function init() {
		parent::init();
		
		$this->setText('&lt;');
		$this->setScrollDeltaX(-3);
		$this->setAttribute('style', '
			background-color:#CCCCCC;
			float:left;
			height:600px;
			width:10px;
			line-height:600px;
		');
	}
}

?>