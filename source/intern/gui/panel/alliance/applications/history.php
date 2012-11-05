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
 * View all the applications sent to your alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Applications_History extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/history.tpl');
		$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$options['conditions'][] = array('status != ?', Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_NEW);
		$options['order'] = 'date DESC';
		$applications = Rakuun_DB_Containers::getAlliancesApplicationsContainer()->select($options);
		$this->addPanel($table = new GUI_Panel_Table('historytable'));
		$table->setAttribute('summary', 'Übersicht über bearbeitete Bewerbungen bei dieser Allianz.');
		$table->addHeader(array('Datum', 'Name', 'Status', 'Bearbeitet durch', 'Bewerbungstext', 'Ablehnungsgrund'));
		foreach ($applications as $application) {
			$line = array();
			$line[] = new GUI_Panel_Date('date'.$application->getPK(), $application->date);
			$line[] = new Rakuun_GUI_Control_UserLink('userlink'.$application->getPK(), $application->user);
			switch ($application->status) {
				case Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_FIRED:
					$line[] = 'Abgelehnt';
					$line[] = new Rakuun_GUI_Control_UserLink('editorlink'.$application->getPK(), $application->editor);
					$line[] = $application->text;
					$line[] = $application->editorNotice;
				break;
				case Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_HIRED:
					$line[] = 'Angenommen';
					$line[] = new Rakuun_GUI_Control_UserLink('editorlink'.$application->getPK(), $application->editor);
					$line[] = $application->text;
					$line[] = '';
				break;
				case Rakuun_Intern_GUI_Panel_Alliance_Applications::STATUS_JOINED_OTHER:
					$line[] = 'ist einer anderen Allianz beigetreten';
					$line[] = '';
					$line[] = $application->text;
					$line[] = '';
				break;
			}
			$table->addLine($line);
		}
	}
}
?>