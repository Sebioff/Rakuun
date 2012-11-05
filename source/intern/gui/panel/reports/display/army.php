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

class Rakuun_Intern_GUI_Panel_Reports_Display_Army extends Rakuun_Intern_GUI_Panel_Reports_Display {
	private $user;
	
	public function __construct($name, Rakuun_DB_User $user, $title = '') {
		parent::__construct($name, $title);
		
		$this->user = $user;
	}
	
	public function init() {
		$options = array();
		$options['conditions'][] = array('spied_user = ?', $this->user);
		$options['conditions'][] = array('deleted = ?', 0);
		$options['order'] = 'time ASC';
		$reports = Rakuun_DB_Containers::getLogSpiesContainer()->select($options);
		if (!empty($reports)) {
			$units = Rakuun_Intern_Production_Factory::getAllUnits();
			$data = array();
			$date = array();
			$i = 0;
			foreach ($reports as $report) {
				if (Rakuun_Intern_GUI_Panel_Reports_Base::hasPrivilegesToSeeReport($report)) {
					foreach ($units as $unit) {
						$data['reports'][$unit->getName()][$i] = $report->{Text::underscoreToCamelCase($unit->getInternalName())};
						$date[$report->time] = date(GUI_Panel_Date::FORMAT_DATE, $report->time);
					}
					$i++;
				}
			}
			$data['date'] = $date;
			$this->setData($data);
		}
		
		parent::init();
	}
}
?>