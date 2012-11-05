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

class Rakuun_Index_Panel_Endscore_BestFighters extends GUI_Panel {
	public function init() {
		$this->setTemplate(dirname(__FILE__).'/bestfighters.tpl');
		
		$this->addPanel($records = new GUI_Panel_Table('bestfighters'));
		$records->addHeader(array('Mit &amp; Ohne Gegenwehr', 'Mit Gegenwehr'));
		$tableRows = array();
		
		$options = array();
		$options['properties'] = 'user, COUNT(*) wins';
		$options['conditions'][] = array('type = ?', Rakuun_Intern_Log_Fights::TYPE_WON);
		$options['group'] = 'user';
		$options['order'] = 'wins DESC';
		$options['limit'] = '10';
		$i = 0;
		foreach (Rakuun_DB_Containers_Persistent::getLogFightsContainer()->select($options) as $fighter) {
			$userLink = new Rakuun_GUI_Control_UserLink('user', $fighter->user, $fighter->get('user'));
			$tableRows[$i][0] = $userLink->render().' - '.Text::formatNumber($fighter->wins).' Siege';
			$i++;
		}
		
		$options = array();
		$options['properties'] = 'attacker.user AS user, COUNT(attacker.user) AS wins';
		$options['conditions'][] = array('attacker.type = ?', Rakuun_Intern_Log_Fights::TYPE_WON);
		$options['conditions'][] = array('attacker.fight_id = defender.fight_id');
		$conditions = array();
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($unit->getBaseDefenseValue() > 0) {
				$conditions[] = 'defender.'.$unit->getInternalName().' > 0';
			}
		}
		$options['conditions'][] = array(implode(' OR ', $conditions));
		$options['join'] = array(array(Rakuun_DB_Containers_Persistent::getLogFightsContainer()->getTable() => 'defender'));
		$options['group'] = 'attacker.user';
		$options['order'] = 'wins DESC';
		$options['limit'] = '10';
		$options['alias'] = 'attacker';
		$i = 0;
		foreach (Rakuun_DB_Containers_Persistent::getLogFightsContainer()->select($options) as $fighter) {
			$userLink = new Rakuun_GUI_Control_UserLink('user', $fighter->user, $fighter->get('user'));
			$tableRows[$i][1] = $userLink->render().' - '.Text::formatNumber($fighter->wins).' Siege';
			$i++;
		}
		
		for ($i = 0; $i < 10; $i++) {
			$tableRow = array();
			if (isset($tableRows[$i][0]))
				$tableRow[] = $tableRows[$i][0];
			else
				$tableRow[] = '';
			if (isset($tableRows[$i][1]))
				$tableRow[] = $tableRows[$i][1];
			else
				$tableRow[] = '';
			$records->addLine($tableRow);
		}
	}
}

?>