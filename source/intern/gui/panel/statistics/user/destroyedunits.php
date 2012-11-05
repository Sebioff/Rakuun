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

class Rakuun_Intern_GUI_Panel_Statistics_User_DestroyedUnits extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/destroyedunits.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		
		$table->addHeader(array('Einheit', 'Angriff', 'Verteidigung', 'Total'));
		
		$properties = array();
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit)
			$properties[] = 'SUM('.$unit->getInternalName().') as '.$unit->getInternalName();
		
		$options = array();
		$options['properties'] = implode(', ', $properties);
		$options['conditions'][] = array('opponent = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_DEFENDER);
		$destroyedInAttack = Rakuun_DB_Containers::getLogFightsContainer()->selectFirst($options);
		
		$options = array();
		$options['properties'] = implode(', ', $properties);
		$options['conditions'][] = array('opponent = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_ATTACKER);
		$destroyedInDefense = Rakuun_DB_Containers::getLogFightsContainer()->selectFirst($options);
		
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			$unitsDestroyedInAttack = $destroyedInAttack->{Text::underscoreToCamelCase($unit->getInternalName())};
			$unitsDestroyedInDefense = $destroyedInDefense->{Text::underscoreToCamelCase($unit->getInternalName())};
			$total = $unitsDestroyedInAttack + $unitsDestroyedInDefense;
			$table->addLine(array($unit->getNameForAmount(2), Text::formatNumber($unitsDestroyedInAttack), Text::formatNumber($unitsDestroyedInDefense), Text::formatNumber($total)));
		}
		$table->addTableCssClass('align_left', 0);
	}
}

?>