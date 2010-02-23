<?php

class Rakuun_Intern_GUI_Panel_Map_Descriptions_Army extends GUI_Panel_HoverInfo {
	private $army = null;
	private $map = null;
	
	public function __construct(DB_Record $army, Rakuun_Intern_GUI_Panel_Map $map) {
		parent::__construct('army'.$army->getPK(), '', '');
		
		$this->army = $army;
		$this->map = $map;
		
		if ($this->army->target && $this->army->target->cityX == $this->army->targetX && $this->army->target->cityY == $this->army->targetY) {
			$hoverText = 'Angriff auf '.$this->army->target->nameUncolored;
		}
		elseif ($this->army->user->cityX == $this->army->targetX && $this->army->user->cityY == $this->army->targetY) {
			$hoverText = 'Rückkehr';
		}
		else {
			$hoverText = 'Ziel: '.$this->army->targetX.':'.$this->army->targetY;
		}
		
		$this->setHoverText($hoverText);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/army.tpl');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($this->army);
		$path = $pathCalculator->getPath($this->army->speed);
		$x = $this->army->positionX * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE;
		$y = $this->army->positionY * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE;
		$this->setAttribute('coords', $x.','.$y.','.($x + 10).','.($y + 10));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_DB_User
	 */
	public function getArmy() {
		return $this->army;
	}
}

?>