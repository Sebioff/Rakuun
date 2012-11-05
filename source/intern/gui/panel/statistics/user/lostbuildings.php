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

class Rakuun_Intern_GUI_Panel_Statistics_User_LostBuildings extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/lostbuildings.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		
		$table->addHeader(array('Gebäude', 'Verlorene Stufen'));
		
		$options = array();
		$options['properties'] = 'SUM(delta_level) as lost_levels, building';
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('event_type = ?', Rakuun_Intern_Event::EVENT_TYPE_BUILDING_DESTROY);
		$options['group'] = 'building';
		foreach (Rakuun_DB_Containers::getLogBuildingsContainer()->select($options) as $lostBuildingLevels) {
			$building = Rakuun_Intern_Production_Factory::getBuilding($lostBuildingLevels->building);
			$line = array($building->getName(), Text::formatNumber(abs($lostBuildingLevels->lostLevels)));
			$table->addLine($line);
		}
		$table->addTableCssClass('align_left', 0);
	}
}

?>