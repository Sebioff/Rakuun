<?php

class Rakuun_GUI_Panel_Box_Note extends Rakuun_GUI_Panel_Box {
	protected $contentPanel = null;
	
	public function __construct($name, GUI_Panel $contentPanel = null, $title = '') {
		parent::__construct($name, $contentPanel, $title);
		
		$this->addClasses('rakuun_box_note');
	}
}

?>