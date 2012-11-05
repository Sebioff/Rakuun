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

/*
 * Shows all Allianceactivities (e.g. join, kick, application, ...) of a user
 */
class Rakuun_Intern_GUI_Panel_User_AllianceHistory extends GUI_Panel {
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user) {
		parent::__construct($name, 'Allianzhistory');
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/alliancehistory.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('alliancehistory', 'Allianzhistory'));
		$table->addHeader(array('Allianz', 'Aktivität', 'Datum'));
		$type = Rakuun_Intern_Alliance_History::getMessageTypes();
		
		$options['conditions'][] = array('user = ?', $this->user->id);
		$options['order'] = 'date DESC';
		$allianceactivities = Rakuun_DB_Containers::getAllianceHistoryContainer()->select($options);
		foreach ($allianceactivities as $allianceactivity) {
			$table->addLine(array($allianceactivity->allianceName, $type[$allianceactivity->type], date('d.m.Y, H:i:s', $allianceactivity->date)));
		}
	}

}

?>