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

/**
 * Displays all multi-activities of a given user
 */
class Rakuun_Intern_GUI_Panel_Multihunting_MultiActionLog extends GUI_Panel {
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		parent::__construct($name, $title);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/multiactionlog.tpl');
		if ($this->user) {
			$this->addPanel($log = new GUI_Panel_Table('log', 'Multi-Aktivität'));
			$log->addHeader(array('Zeit', 'User', 'Übereinstimmung', 'Aktion'));
			$i = 0;
			foreach (Rakuun_DB_Containers::getLogMultiactionsUsersAssocContainer()->selectByUser($this->user) as $activity) {
				foreach (Rakuun_DB_Containers::getLogMultiactionsUsersAssocContainer()->selectByMultiAction($activity->multiAction) as $action) {
					if ($activity->user != $action->user) {
						$date = new GUI_Panel_Date('date'.$i++, $action->multiAction->time);
						$log->addLine(array($date, $action->user->name, Rakuun_Intern_Log::getMultiActionDescription($action->multiAction->multiaction), Rakuun_Intern_Log::getActionDescription($action->multiAction->action)));
					}
				}
			}
		}
	}
}

?>