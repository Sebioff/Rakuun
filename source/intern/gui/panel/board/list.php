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

class Rakuun_Intern_GUI_Panel_Board_List extends GUI_Panel {
	private $boards = array();
	private $config = null;
	
	public function __construct($name, Board_Config $config, array $boards, $title = '') {
		parent::__construct($name, $title);
		
		$this->boards = $boards;
		$this->config = $config;
	}
	
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$module = $this->config->getBoardModule();
		$this->addPanel($table = new GUI_Panel_Table('board'));
		$header = array();
		$header[] = 'Name';
		$header[] = 'Beiträge';
		$header[] = 'Letzte Änderung';
		if ($module->getParam('moderate') == $user->getPK()) {
			$header[] = 'löschen';
			$header[] = 'schließen';
			$this->addPanel(new GUI_Control_SubmitButton('edit', 'Namen speichern'));
		}
		$table->addHeader($header);
		foreach ($this->boards as $board) {
			$line = array();
			$options = array();
			$options['conditions'][] = array('board = ?', $board);
			if ($this->config->getIsGlobal()) {
				$options['conditions'][] = array('user_name = ?', $user->nameUncolored);
				$options['conditions'][] = array('round_number = ?', RAKUUN_ROUND_NAME);
			} else {
				$options['conditions'][] = array('user = ?', $user);
			}
			if ($module->getParam('moderate') == $user->getPK()) {
				$box = new GUI_Control_Textbox('boardname'.$board->getPK(), $board->name);
				$box->addValidator(new GUI_Validator_Mandatory());
				$box->addValidator(new GUI_Validator_RangeLength(2, 25));
				$line[] = $box;
			} else {
				$lastVisit = $this->config->getVisitedContainer()->selectFirst($options);
				
				$urlParams = array('board' => $board->id);
				if (!$lastVisit || $lastVisit->date < $board->date)
					$urlParams['show'] = 'recent';
				
				$link = new GUI_Control_Link('boardname'.$board->getPK(), $board->name, $module->getUrl($urlParams));
				if (!$lastVisit || $lastVisit->date < $board->date) {
					if ($this->config->getIsGlobal()) {
						$options = array();
						$options['conditions'][] = array('board = ?', $board);
						$options['conditions'][] = array('date >= ?', RAKUUN_ROUND_STARTTIME);
						if ($this->config->getPostingsContainer()->selectFirst($options))
							$link->setAttribute('style', 'font-weight:bold');
					} else {
						$link->setAttribute('style', 'font-weight:bold');
					}
				}
				$line[] = $link;
			}
			$line[] = $this->config->getPostingsContainer()->countByBoard($board);
			$line[] = new GUI_Panel_Date('date'.$board->getPK().$this->getName(), $board->date);
			if ($module->getParam('moderate') == $user->getPK()) {
				$blanko = new GUI_Panel('moderate'.$board->getPK());
				$blanko->addPanel($delete = new GUI_Control_SubmitButton('delete', 'Löschen'));
				$delete->addCallback(array($this, 'onDeleteCustom'), array($board));
				$delete->setConfirmationMessage('Das Forum `'.$board->name.'` wirklich löschen?');
				$line[] = $blanko;
				$blanko = new GUI_Panel('close'.$board->getPK());
				$close = new GUI_Control_SubmitButton('close', ($board->closed ? 'Öffnen' : 'Schließen'));
				$close->setConfirmationMessage('Das Forum `'.$board->name.'` wirklich '.($board->closed ? 'öffnen' : 'schließen?'));
				$close->addCallback(array($this, 'onCloseCustom'), array($board));
				$blanko->addPanel($close);
				$line[] = $blanko;
			}
			$table->addLine($line);
		}
	}
	
	public function onEdit() {
		if ($this->hasErrors())
			return;
		
		foreach ($this->boards as $board) {
			if ($board->name != $this->board->{'boardname'.$board->getPK()}->getValue()) {
				$board->name = $this->board->{'boardname'.$board->getPK()}->getValue();
				$board->date = time();
				$board->save();
			}
		}
		$this->getModule()->invalidate();
	}
	
	public function onDeleteCustom($board) {
		if ($this->getModule()->getParam('moderate') != Rakuun_User_Manager::getCurrentUser()->getPK() || $this->hasErrors())
			return;
		
		$board->delete();
		$this->getModule()->invalidate();
	}
	
	public function onCloseCustom($board) {
		if ($this->getModule()->getParam('moderate') != Rakuun_User_Manager::getCurrentUser()->getPK() || $this->hasErrors())
			return;
		
		$board->closed = !$board->closed;
		$board->save();
		$this->getModule()->invalidate();
	}
}
?>