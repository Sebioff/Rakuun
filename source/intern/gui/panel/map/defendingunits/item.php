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

class Rakuun_Intern_GUI_Panel_Map_DefendingUnits_Item extends GUI_Panel {
	private $unit = null;
	
	public function __construct($name, Rakuun_Intern_Production_Unit $unit) {
		parent::__construct($name);
		$this->unit = $unit;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/item.tpl');
		$this->addPanel(new GUI_Panel_Text('value_panel', $this->unit->getNameForAmount(2) .' ('.Text::formatNumber($this->unit->getAmount()).')'));
		$fightingSequence = explode('|', Rakuun_User_Manager::getCurrentUser()->units->fightingSequence);
		$position = array_search($this->unit->getInternalName(), $fightingSequence);
		if ($position < count($fightingSequence) - 1) {
			$this->addPanel($upButton = new GUI_Control_SubmitButton('move_up'));
			$upButton->addClasses('rakuun_btn_move_up');
		}
		if ($position > 0) {
			$this->addPanel($downButton = new GUI_Control_SubmitButton('move_down'));
			$downButton->addClasses('rakuun_btn_move_down');
		}
	}
	
	public function onMoveUp() {
		$fightingSequence = explode('|', Rakuun_User_Manager::getCurrentUser()->units->fightingSequence);
		$position = array_search($this->unit->getInternalName(), $fightingSequence);
		if ($position < count($fightingSequence) - 1) {
			$moveTo = 0;
			for ($i = $position + 1; $i <= count($fightingSequence) - 1; $i++) {
				$unit = Rakuun_Intern_Production_Factory::getUnit($fightingSequence[$i]);
				if ($unit->getAmount() > 0 && $unit->getBaseDefenseValue() > 0) {
					$moveTo = $i;
					break;
				}
			}
			$temp = $fightingSequence[$position];
			$fightingSequence[$position] = $fightingSequence[$moveTo];
			$fightingSequence[$moveTo] = $temp;
		}
		Rakuun_User_Manager::getCurrentUser()->units->fightingSequence = implode('|', $fightingSequence);
		Rakuun_User_Manager::getCurrentUser()->units->save();
		$this->getModule()->invalidate();
	}
	
	public function onMoveDown() {
		$fightingSequence = explode('|', Rakuun_User_Manager::getCurrentUser()->units->fightingSequence);
		$position = array_search($this->unit->getInternalName(), $fightingSequence);
		if ($position > 0) {
			$moveTo = 0;
			for ($i = $position - 1; $i >= 0; $i--) {
				$unit = Rakuun_Intern_Production_Factory::getUnit($fightingSequence[$i]);
				if ($unit->getAmount() > 0 && $unit->getBaseDefenseValue() > 0) {
					$moveTo = $i;
					break;
				}
			}
			$temp = $fightingSequence[$position];
			$fightingSequence[$position] = $fightingSequence[$moveTo];
			$fightingSequence[$moveTo] = $temp;
		}
		Rakuun_User_Manager::getCurrentUser()->units->fightingSequence = implode('|', $fightingSequence);
		Rakuun_User_Manager::getCurrentUser()->units->save();
		$this->getModule()->invalidate();
	}
}

?>