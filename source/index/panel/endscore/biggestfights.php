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

class Rakuun_Index_Panel_Endscore_BiggestFights extends GUI_Panel {
	public function init() {
		$this->setTemplate(dirname(__FILE__).'/biggestfights.tpl');
		
		$properties = array('user', 'opponent', 'time', 'type', 'role');
		$totalForceProperty = array();
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			$properties[] = 'SUM('.$unit->getInternalName().') AS '.$unit->getInternalName().'_sum';
			$totalForceProperty[] = 'SUM('.$unit->getInternalName().') * '.$unit->getBaseArmyStrength();
		}
		
		$options = array();
		$options['properties'] = implode(', ', $properties).', '.implode(' + ', $totalForceProperty).' AS total_force';
		$options['group'] = 'fight_id';
		$options['order'] = 'total_force DESC';
		$options['limit'] = '5';
		$this->params->fights = Rakuun_DB_Containers_Persistent::getLogFightsContainer()->select($options);
	}
}

?>