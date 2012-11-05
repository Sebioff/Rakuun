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

class Rakuun_Intern_GUI_Panel_Statistics_Economy extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/economy.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		$table->addTableCssClass('align_left', 0);
		$table->addHeader(array('Name', 'Wert'));
		
		$options = array();
		$properties = array();
		$buildings = Rakuun_Intern_Production_Factory::getAllBuildings();
		foreach ($buildings as $building) {
			if ($building->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INVISIBLE_FOR_SPIES) === true)
				continue;
			
			$properties[] = 'SUM('.$building->getInternalName().') AS '.$building->getInternalName().'_sum';
		}
		$options['properties'] = implode(', ', $properties);
		$buildingAmounts = Rakuun_DB_Containers::getBuildingsContainer()->selectFirst($options);
		$usersCount = Rakuun_Intern_Statistics::noOfPlayers();
		foreach ($buildings as $building) {
			if ($building->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INVISIBLE_FOR_SPIES) === true)
				continue;
			
			$line = array('&oslash; Stufe '.$building->getName(), Text::formatNumber(round($buildingAmounts->{Text::underscoreToCamelCase($building->getInternalName().'_sum')} / $usersCount)));
			$table->addLine($line);
		}
	}

}

?>