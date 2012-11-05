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
 * Displays all or one specific board.
 */
abstract class Rakuun_Intern_GUI_Panel_Board extends GUI_Panel_PageView {
	protected $config = null;
	
	public function __construct($name, $title = '') {
		$this->setItemsPerPage(20);
			
		parent::__construct($name, $this->config->getBoardsContainer(), $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/board.tpl');
		if (($boardId = Router::get()->getCurrentModule()->getParam('board')) > 0) {
			// Board darstellen
			$board = $this->config->getBoardsContainer()->selectByIdFirst($boardId);
			if ($board === null) {
				$this->addError('Du hast keinen Zugriff auf das Forum mit der ID '.$boardId);
				return;
			}
			$this->config->setBoardRecord($board);
			$this->initWithSingleBoard();
		} else {
			$this->initWithBoards();
		}
	}
	
	protected function initWithSingleBoard() {
		$this->addPanel(
			new Rakuun_Intern_GUI_Panel_Board_PostingView(
				'board',
				$this->config
			)
		);
	}
	
	private function initWithBoards() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$options = array();
		$options['order'] = 'date DESC';
		$boards = $this->getContainer()->select(DB_Container::mergeOptions($this->getOptions(), $options));
		$module = $this->getModule();
		if ($this->config->getUserIsMod()) {
			if ($module->getParam('moderate') == $user->getPK()) {
				$this->addPanel(new GUI_Control_Link('moderatelink', '-zurück-', $module->getUrl()));
			} else {
				$this->addPanel(new GUI_Control_Link('moderatelink', '-moderieren-', $module->getUrl(array('moderate' => $user->getPK()))));
			}
		}
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_List('board', $this->config, $boards));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_AddBoard('addboard', $this->config));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_MarkRead('markread', $this->config));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_Search('suchen', $this->config));
	}
	
	public function showPages() {
		return ($this->getPageCount() > 1 && Router::get()->getCurrentModule()->getParam('board') === null);
	}
}

class Board_Config {
	private $boardsContainer = null;
	private $boardRecord = null;
	private $module = null;
	private $postingsContainer = null;
	private $postingRecord = null;
	private $visitedContainer = null;
	private $isGlobal = false;
	private $userIsMod = false;
	private $security = null;

	public function getBoardsContainer() {
		return $this->boardsContainer;
	}
	
	public function setBoardsContainer(DB_Container $container) {
		$this->boardsContainer = $container;
	}
	
	public function getBoardRecord() {
		return $this->boardRecord;
	}
	
	public function setBoardRecord(DB_Record $record) {
		$this->boardRecord = $record;
	}
	
	public function getPostingsContainer() {
		return $this->postingsContainer;
	}
	
	public function setPostingsContainer(DB_Container $container) {
		$this->postingsContainer = $container;
	}
	
	public function getPostingRecord() {
		return $this->postingRecord;
	}
	
	public function setPostingRecord(DB_Record $record) {
		$this->postingRecord = $record;
	}
	
	public function getVisitedContainer() {
		return $this->visitedContainer;
	}
	
	public function setVisitedContainer(DB_Container $container) {
		$this->visitedContainer = $container;
	}
	
	public function setIsGlobal($global) {
		$this->isGlobal = (bool)$global;
	}
	
	public function getIsGlobal() {
		return $this->isGlobal;
	}
	
	public function setBoardModule(Rakuun_Intern_Module $module) {
		$this->module = $module;
	}
	
	public function getBoardModule() {
		return $this->module;
	}
	
	public function setUserIsMod($mod) {
		$this->userIsMod = (bool)$mod;
	}
	
	public function getUserIsMod() {
		return $this->userIsMod;
	}
	
	public function setSecurity(Security $security) {
		$this->security = $security;
	}
	
	public function getSecurity() {
		return $this->security;
	}
}
?>