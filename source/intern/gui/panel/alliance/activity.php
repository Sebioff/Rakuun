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
 * Display the last activity of each alliance member.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Activity extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/activity.tpl');
		$options['order'] = 'last_activity DESC';
		$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$members = Rakuun_DB_Containers::getUserContainer()->select($options);
		$this->addPanel($table = new GUI_Panel_Table('table'));
		$table->enableSortable();
		$table->addHeader(array('Name', 'Letzte Aktivität'));
		foreach ($members as $member) {
			$table->addLine(
				array(
					new Rakuun_GUI_Control_UserLink('userlink'.$member->getPK(), $member),
					new GUI_Panel_Date('date'.$member->getPK(), $member->lastActivity)
				)
			);
		}
		$table->setAttribute('summary', 'Member Aktivitätsübersicht');
	}
}

?>