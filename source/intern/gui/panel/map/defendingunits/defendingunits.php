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

class Rakuun_Intern_GUI_Panel_Map_DefendingUnits extends GUI_Panel {
	private $panelsForDefendingUnits = array();
	private $panelsForOtherUnits = array();
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/defendingunits.tpl');
		$fightingSequence = array_reverse(explode('|', Rakuun_User_Manager::getCurrentUser()->units->fightingSequence));
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($unit->getAmount() > 0) {
				if ($unit->getBaseDefenseValue() > 0) {
					$this->addPanel($itemPanel = new Rakuun_Intern_GUI_Panel_Map_DefendingUnits_Item($unit->getInternalName(), $unit));
					$this->panelsForDefendingUnits[array_search($unit->getInternalName(), $fightingSequence)] = $itemPanel;
				}
				else {
					$this->addPanel($itemPanel = new GUI_Panel_Text($unit->getInternalName(), $unit->getNameForAmount(2) .' ('.Text::formatNumber($unit->getAmount()).')'));
					$this->panelsForOtherUnits[] = $itemPanel;
				}
			}
		}
		ksort($this->panelsForDefendingUnits);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getPanelsForDefendingUnits() {
		return $this->panelsForDefendingUnits;
	}
	
	public function getPanelsForOtherUnits() {
		return $this->panelsForOtherUnits;
	}
}

?>