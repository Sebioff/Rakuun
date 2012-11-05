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

class Rakuun_Intern_GUI_Panel_Map_Fights_OutgoingArmy extends GUI_Panel {
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
		$countdownPanel->setFinishedMessage('Kürze...');
		$countdownPanel->enableHoverInfo(true);
		
		$target = 0;
		$detailUrl = App::get()->getInternModule()->getSubmodule('fightdetails')->getUrl(array('id' => $this->army->getPK()));
		if ($this->army->target && $this->army->target->cityX == $this->army->targetX && $this->army->target->cityY == $this->army->targetY) {
			$target = self::TARGET_ENEMY;
			$this->addPanel(new GUI_Control_Link('text', 'Kampf gegen '.$this->army->target->name, $detailUrl));
		}
		elseif ($this->army->user->cityX == $this->army->targetX && $this->army->user->cityY == $this->army->targetY) {
			$target = self::TARGET_HOME;
			if ($this->army->target)
				$this->addPanel(new GUI_Control_Link('text', 'Rückkehr von '.$this->army->target->name, $detailUrl));
			else
				$this->addPanel(new GUI_Control_Link('text', 'Rückkehr von '.$this->army->targetX.':'.$this->army->targetY, $detailUrl));
		}
		else {
			$target = self::TARGET_MAP;
			$this->addPanel(new GUI_Control_Link('text', 'Ankunft bei '.$this->army->targetX.':'.$this->army->targetY, $detailUrl));
		}
		
		if ($target == self::TARGET_ENEMY || $target == self::TARGET_MAP) {
			$this->addPanel($cancelButton = new GUI_Control_SecureSubmitButton('cancel'));
			$cancelButton->addClasses('rakuun_btn_cancel');
			$cancelButton->setConfirmationMessage('Armee zurückrufen?');
		}
		
		
		$this->setTemplate(dirname(__FILE__).'/outgoingarmy.tpl');
	}
	
	public function onCancel() {
		DB_Connection::get()->beginTransaction();
		// calculate armies current position
		$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($this->army);
		$pathCalculator->getPath();
		Rakuun_DB_Containers::getArmiesPathsContainer()->deleteByArmy($this->army);
		$this->army->targetX = $this->army->user->cityX;
		$this->army->targetY = $this->army->user->cityY;
		$this->army->tick = time();
		$this->army->targetTime = 0;
		// calculate armies return time
		$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($this->army);
		$pathCalculator->getPath();
		$this->army->save();
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getArmy() {
		return $this->army;
	}
}

?>