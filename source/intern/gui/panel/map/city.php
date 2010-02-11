<?php

class Rakuun_Intern_GUI_Panel_Map_City extends GUI_Panel_HoverInfo {
	private $cityOwner = null;
	private $map = null;
	
	public function __construct(Rakuun_DB_User $cityOwner, Rakuun_Intern_GUI_Panel_Map $map) {
		parent::__construct('city'.$cityOwner->getPK(), '', '');
		
		$this->cityOwner = $cityOwner;
		$this->map = $map;
		
		$hoverText = $cityOwner->nameUncolored.
			'<br/>'.Text::escapeHTML($cityOwner->cityName).
			'<br/>Punkte: '.GUI_Panel_Number::formatNumber($cityOwner->points);
		$this->setHoverText($hoverText);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/city.tpl');
		$this->addClasses('scroll_item');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$style = array(
			'cursor:pointer',
			'position:absolute',
			'background-color:green',
			'height:'.Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px',
			'width:'.Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE.'px',
			'left:'.$this->map->realToViewPositionX($this->cityOwner->cityX).'px',
			'top:'.$this->map->realToViewPositionY($this->cityOwner->cityY).'px'
		);
		$this->setAttribute('style', implode(';', $style));
	}
}

?>