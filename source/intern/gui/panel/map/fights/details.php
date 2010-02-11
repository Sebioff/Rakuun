<?php

class Rakuun_Intern_GUI_Panel_Map_Fights_Details extends GUI_Panel {
	const TARGET_ENEMY = 1;
	const TARGET_HOME = 2;
	const TARGET_MAP = 3;
	
	private $army = null;
	
	public function __construct($name, DB_Record $army) {
		parent::__construct($name);
		$this->army = $army;
	}
	
	public function init() {
		parent::init();
		
		$this->addPanel($countdownPanel = new Rakuun_GUI_Panel_CountDown('countdown', $this->army->targetTime));
		$countdownPanel->enableHoverInfo(true);
		
		$target = 0;
		if ($this->army->target && $this->army->target->cityX == $this->army->targetX && $this->army->target->cityY == $this->army->targetY) {
			$target = self::TARGET_ENEMY;
			$this->addPanel(new GUI_Panel_Text('text', 'Kampf gegen '.$this->army->target->name));
		}
		elseif ($this->army->user->cityX == $this->army->targetX && $this->army->user->cityY == $this->army->targetY) {
			$target = self::TARGET_HOME;
			$this->addPanel(new GUI_Panel_Text('text', 'Rückkehr'));
		}
		else {
			$target = self::TARGET_MAP;
			$this->addPanel(new GUI_Panel_Text('text', 'Ankunft bei '.$this->army->targetX.':'.$this->army->targetY));
		}
		
		$this->setTemplate(dirname(__FILE__).'/details.tpl');
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getArmy() {
		return $this->army;
	}
}

?>