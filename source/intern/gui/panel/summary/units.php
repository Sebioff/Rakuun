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

class Rakuun_Intern_GUI_Panel_Summary_Units extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/summary.tpl');
		
		$table = new GUI_Panel_Table('summary');
		$summeAtt = 0;
		$summeDeff = 0;
		$summeArmystrength = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($unit->getAmount() > 0) {
				$table->addLine(
					array(
						new GUI_Control_Link('link'.$unit->getInternalName(), $unit->getName(), App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $unit->getType(), 'id' => $unit->getInternalName()))),
						Text::formatNumber($unit->getAmount()),
						Text::formatNumber($unit->getAttackValue()),
						Text::formatNumber($unit->getDefenseValue()),
						Text::formatNumber($unit->getArmyStrength())
					)
				);
				$summeAtt += $unit->getAttackValue();
				$summeDeff += $unit->getDefenseValue();
				$summeArmystrength += $unit->getArmyStrength();
			}
		}
		if (count($table->getLines()) == 0)
			$this->addPanel(new GUI_Panel_Text('summary', 'Keine.'));
		else {
			$table->addHeader(array('Name', 'Anzahl', 'Att', 'Deff', 'Armeestärke'));
			$table->addFooter(array('Summe:', '', Text::formatNumber($summeAtt), Text::formatNumber($summeDeff), Text::formatNumber($summeArmystrength)));
			$wall = Rakuun_Intern_Production_Factory::getBuilding('city_wall');
			if ($wall->getLevel() > 0)
				$table->addFooter(array('Summe ohne Mauer:', '', '', Text::formatNumber($summeDeff - ($summeDeff / (1 + (100 / ($wall->getLevel() * Rakuun_Intern_Production_Building_CityWall::DEFENSE_BONUS_PERCENT))))), ''));
			$this->addPanel($table);
		}
		$table->addTableCssClass('align_left', 0);
	}
}
?>