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

class Rakuun_Intern_GUI_Panel_Reports_ForUser extends Rakuun_Intern_GUI_Panel_Reports_Base {
	private $user;
	
	public function __construct($name, Rakuun_DB_User $user, Rakuun_GUI_Panel_Box $detailBox, $title = '') {
		parent::__construct($name, $detailBox, $title);
		
		$this->user = $user;
	}
	
	public function afterInit() {
		$options = array();
		$options['conditions'][] = array('spied_user = ?', $this->user);
		$options['conditions'][] = array('deleted = ?', 0);
		$options['order'] = 'time DESC';
		$options['limit'] = Rakuun_Intern_GUI_Panel_Reports_Base::MAX_REPORTS_TO_LOAD;
		$this->data = Rakuun_DB_Containers::getLogSpiesContainer()->select($options);
		
		parent::afterInit();
	}
}
?>