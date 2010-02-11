<?php

class Rakuun_Intern_GUI_Panel_Map_Path extends GUI_Panel {
	private $map = null;
	
	public function __construct($name, Rakuun_Intern_GUI_Panel_Map $map) {
		parent::__construct($name);
		
		$this->map = $map;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/path.tpl');
		$this->addClasses('scroll_bg');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$style = array(
			'position:absolute',
			'height:'.$this->map->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px',
			'width:'.$this->map->getViewRectSize() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px',
			'background:transparent url('.App::get()->getMapPathModule()->getURL().') '.(-$this->map->getViewRectX() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px '.(-$this->map->getViewRectY() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE).'px'
		);
		$this->setAttribute('style', implode(';', $style));
	}
}

?>