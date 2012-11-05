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
 * shows the active users who are still online.
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_User_Online extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/online.tpl');
		$this->addPanel($onlineusers = new GUI_Panel_Table('onlineusers'));
		$onlineusers->addHeader(array('Username', 'Allianz'));
		
		$options = array();
		$options['conditions'][] = array('is_online > ?', time() - Rakuun_Intern_Module::TIMEOUT_ISONLINE);
		$options['order'] = 'name ASC';
		$onlineUsers = Rakuun_DB_Containers::getUserContainer()->select($options);
		foreach ($onlineUsers as $user){
			$line = array();
			$line[] = new Rakuun_GUI_Control_UserLink('userlink'.$user->getPK(), $user);
			if ($user->alliance) {
				$line[] = new Rakuun_GUI_Control_AllianceLink('alliance'.$user->getPK(), $user->alliance);
			} else {
				$line[] = '';
			}
			$onlineusers->addLine($line);
		}
		$this->params->onlineCount = count($onlineUsers);
	}
}

?>