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
 * Search the Activitylog.
 */
class Rakuun_Intern_GUI_Panel_Multihunting_Search extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/search.tpl');
		$this->addPanel($name = new GUI_Control_TextBox('name', null, 'Username'));
		$this->addPanel($ip = new GUI_Control_TextBox('ip', null, 'IP'));
		$this->addPanel($hostname = new GUI_Control_TextBox('hostname', null, 'Hostname'));
		$this->addPanel($browser = new GUI_Control_TextBox('browser', null, 'Browser'));
		$this->addPanel($email = new GUI_Control_TextBox('email', null, 'Email'));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Suchen'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;

		$options = array();
		//$options['conditions'][] = array('name LIKE ?', '%'.str_replace('*', '%', $this->name).'%');
		$options['conditions'][] = array('ip LIKE ?', '%'.str_replace('*', '%', $this->ip).'%');
		$options['conditions'][] = array('hostname LIKE ?', '%'.str_replace('*', '%', $this->hostname).'%');
		$options['conditions'][] = array('browser LIKE ?', '%'.str_replace('*', '%', $this->browser).'%');
		//$options['conditions'][] = array('email LIKE ?', '%'.str_replace('*', '%', $this->name).'%');
		$options['order'] = 'user ASC';
		$logs = Rakuun_DB_Containers::getLogUserActivityContainer()->select($options);
		$this->params->logs = $logs;
	}
}

?>