<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

class Rakuun_Intern_GUI_Panel_Map_Fights_Details extends GUI_Panel {
	const TARGET_ENEMY = 1;
	const TARGET_HOME = 2;
	const TARGET_MAP = 3;
	
	private $army = null;
	private $target = 0;
	
	public function __construct($name, DB_Record $army) {
		parent::__construct($name);
		$this->army = $army;
	}
	
	public function init() {
		parent::init();
		
		$this->addPanel($countdownPanel = new Rakuun_GUI_Panel_CountDown('countdown', $this->army->targetTime));
		$countdownPanel->enableHoverInfo(true);
		
		if ($this->army->target && $this->army->target->cityX == $this->army->targetX && $this->army->target->cityY == $this->army->targetY) {
			$this->target = self::TARGET_ENEMY;
			$this->addPanel(new GUI_Panel_Text('text', 'Kampf gegen '.$this->army->target->name));
		}
		elseif ($this->army->user->cityX == $this->army->targetX && $this->army->user->cityY == $this->army->targetY) {
			$this->target = self::TARGET_HOME;
			if ($this->army->target)
				$this->addPanel(new GUI_Panel_Text('text', 'Rückkehr von '.$this->army->target->name));
			else
				$this->addPanel(new GUI_Panel_Text('text', 'Rückkehr von '.$this->army->targetX.':'.$this->army->targetY));
		}
		else {
			$this->target = self::TARGET_MAP;
			$this->addPanel(new GUI_Panel_Text('text', 'Ankunft bei '.$this->army->targetX.':'.$this->army->targetY));
		}
		
		$this->setTemplate(dirname(__FILE__).'/details.tpl');
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getArmy() {
		return $this->army;
	}
	
	public function getTarget() {
		return $this->target;
	}
}

?>