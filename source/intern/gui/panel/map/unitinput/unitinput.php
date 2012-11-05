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

class Rakuun_Intern_GUI_Panel_Map_UnitInput extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/unitinput.tpl');
		$attackSequence = array_reverse(explode('|', Rakuun_User_Manager::getCurrentUser()->units->attackSequence));
		foreach ($attackSequence as $unitName) {
			$unit = Rakuun_Intern_Production_Factory::getUnit($unitName);
			if ($unit->getBaseAttackValue() > 0 && $unit->getAmount() > 0) {
				$this->addPanel(new Rakuun_Intern_GUI_Panel_Map_UnitInput_Item($unit->getInternalName(), $unit));
			}
		}
	}
	
	public function getArmy(DB_Record $unitSource = null) {
		$army = array();
		
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($unitSource) as $unit) {
			if ($this->hasPanel($unit->getInternalName()) && $this->{Text::underscoreToCamelCase($unit->getInternalName())}->valuePanel->getValue() > 0
			&& $this->{Text::underscoreToCamelCase($unit->getInternalName())}->valuePanel->getValue() <= $unit->getAmount()
			) {
				$army[$unit->getInternalName()] = $this->{Text::underscoreToCamelCase($unit->getInternalName())}->valuePanel->getValue();
			}
		}
		
		return $army;
	}
}

?>