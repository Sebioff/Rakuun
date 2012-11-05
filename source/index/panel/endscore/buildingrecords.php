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

class Rakuun_Index_Panel_Endscore_BuildingRecords extends GUI_Panel {
	public function init() {
		$this->setTemplate(dirname(__FILE__).'/buildingrecords.tpl');
		
		$this->addPanel($records = new GUI_Panel_Table('records'));
		$records->addHeader(array('Gebäude', 'Spieler', 'Stufe'));
		
		foreach (Rakuun_Intern_Production_Factory::getAllBuildings() as $building) {
			if ($building->getMaximumLevel() < 0) {
				$options = array();
				$options['properties'] = $building->getInternalName().' AS highest_level, user';
				$options['order'] = $building->getInternalName().' DESC';
				$record = Rakuun_DB_Containers_Persistent::getBuildingsContainer()->selectFirst($options);
				$userLink = new Rakuun_GUI_Control_UserLink('user', $record->user, $record->get('user'));
				$records->addLine(array($building->getName(), $userLink->render(), $record->highestLevel));
			}
		}
	}
}

?>