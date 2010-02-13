<?php

class Rakuun_Intern_GUI_Panel_Map_Database extends GUI_Panel_HoverInfo {
	private $databaseIdentifier = 0;
	private $positionX = 0;
	private $positionY = 0;
	private $map = null;
	
	public function __construct(Rakuun_Intern_GUI_Panel_Map $map, $databaseIdentifier, $positionX, $positionY) {
		parent::__construct('db'.$databaseIdentifier, '', '');
		
		$this->map = $map;
		$this->databaseIdentifier = $databaseIdentifier;
		$this->positionX = $positionX;
		$this->positionY = $positionY;

		$this->setHoverText('Datenbank');
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/database.tpl');
		$this->addClasses('scroll_item');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$style = array(
			'background-color:yellow',
			'left:'.$this->map->realToViewPositionX($this->positionX).'px',
			'top:'.$this->map->realToViewPositionY($this->positionY).'px'
		);
		$this->setAttribute('style', implode(';', $style));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getPositionX() {
		return $this->positionX;
	}
	
	public function getPositionY() {
		return $this->positionY;
	}
}

?>