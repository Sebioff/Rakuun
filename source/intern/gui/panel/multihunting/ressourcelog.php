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
 * Displays all ressource (incomming) transfers of a given user
 */
class Rakuun_Intern_GUI_Panel_Multihunting_RessourceLog extends GUI_Panel {
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		parent::__construct($name, $title);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/ressourcelog.tpl');
		if ($this->user) {
			$this->addPanel($log = new GUI_Panel_Table('log', 'Ressourcen-Transfers'));
			$log->addHeader(array('Typ', 'User', 'Aktion', 'Zeit', 'Eisen', 'Beryllium', 'Energie', 'Leute', 'IP', 'Hostname', 'Browser'));

			$options = array();
			$options['conditions'][] = array('user = ? OR sender = ?', $this->user->getPK(), $this->user->getPK());
			$options['order'] = 'time DESC';
			foreach (Rakuun_DB_Containers::getLogUserRessourcetransferContainer()->select($options) as $ressourcetransfer) {
				$date = new GUI_Panel_Date('date'.$ressourcetransfer->getPK(), $ressourcetransfer->time);
				$ip = new GUI_Control_Link('url'.$ressourcetransfer->getPK(), $ressourcetransfer->ip, Rakuun_Intern_Log::IPWHOIS.$ressourcetransfer->ip);
				$action = Rakuun_Intern_Log::getActionDescription($ressourcetransfer->action);
				if ($ressourcetransfer->user == $this->user) {
					$type = Rakuun_Intern_Log::getTypeTransferDescription(Rakuun_Intern_Log::TYPE_TRANSFER_IN);
					$user = new Rakuun_GUI_Control_UserLink('user'.$ressourcetransfer->getPK(), $ressourcetransfer->sender, $ressourcetransfer->get('sender'));
				} else {
					$type = Rakuun_Intern_Log::getTypeTransferDescription(Rakuun_Intern_Log::TYPE_TRANSFER_OUT);
					$user = new Rakuun_GUI_Control_UserLink('user'.$ressourcetransfer->getPK(), $ressourcetransfer->user, $ressourcetransfer->get('user'));
				}
				$log->addLine(array($type, $user, $action, $date, $ressourcetransfer->iron, $ressourcetransfer->beryllium, $ressourcetransfer->energy, $ressourcetransfer->people, $ip, $ressourcetransfer->hostname, $ressourcetransfer->browser));
			}
			
			//display all donations to alliances
			$options = array();
			$options['conditions'][] = array('sender = ? AND type = ?', $this->user->getPK(), Rakuun_Intern_GUI_Panel_Alliance_Account::TYPE_USER_TO_ALLIANCE);
			foreach (Rakuun_DB_Containers::getAlliancesAccountlogContainer()->select($options) as $ressourcetransfer) {
				$date = new GUI_Panel_Date('date_'.$ressourcetransfer->getPK(), $ressourcetransfer->date);
				$ip = new GUI_Control_Link('url_'.$ressourcetransfer->getPK(), $ressourcetransfer->ip, Rakuun_Intern_Log::IPWHOIS.$ressourcetransfer->ip);
				$action = Rakuun_Intern_Log::getActionDescription(Rakuun_Intern_Log::ACTION_RESSOURCES_ALLIANCE);
				$type = Rakuun_Intern_Log::getTypeTransferDescription(Rakuun_Intern_Log::TYPE_TRANSFER_FROM);
				$user = new Rakuun_GUI_Control_UserLink('user_'.$ressourcetransfer->getPK(), $ressourcetransfer->sender, $ressourcetransfer->get('sender'));
				$log->addLine(array($type, $user, $action, $date, $ressourcetransfer->iron, $ressourcetransfer->beryllium, $ressourcetransfer->energy, $ressourcetransfer->people, $ip, $ressourcetransfer->hostname, $ressourcetransfer->browser));
			}
		}
	}
}

?>