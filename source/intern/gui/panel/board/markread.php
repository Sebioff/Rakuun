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

class Rakuun_Intern_GUI_Panel_Board_MarkRead extends GUI_Panel {
	private $config = null;
	
	public function __construct($name, Board_Config $config, $title = '') {
		$this->config = $config;
		
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->addPanel(new GUI_Control_SubmitButton('markread', 'Alle als gelesen markieren'));
	}
	
	public function onMarkRead() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$lastVisitedContainer = $this->config->getVisitedContainer();
		$boards = $this->config->getBoardsContainer()->select();
		DB_Connection::get()->beginTransaction();
		foreach ($boards as $board) {
			$options = array();
			$options['conditions'][] = array('board = ?', $board);
			if ($this->config->getIsGlobal()) {
				$options['conditions'][] = array('user_name = ?', $user->nameUncolored);
				$options['conditions'][] = array('round_number = ?', RAKUUN_ROUND_NAME);
			} else {
				$options['conditions'][] = array('user = ?', $user);
			}
			$newVisit = $lastVisitedContainer->selectFirst($options);
			if ($newVisit === null)
				$newVisit = new DB_Record();
			$newVisit->board = $board;
			if ($this->config->getIsGlobal()) {
				$newVisit->userName = $user->nameUncolored;
				$newVisit->roundNumber = RAKUUN_ROUND_NAME;
			} else {
				$newVisit->user = $user;
			}
			$newVisit->date = time();
			$lastVisitedContainer->save($newVisit);
		}
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
}
?>