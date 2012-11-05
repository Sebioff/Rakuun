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
 * Displays all threads of a specific board.
 */
class Rakuun_Intern_GUI_Panel_Board_PostingView extends GUI_Panel_PageView {
	private $config = null;
	
	public function __construct($name, Board_Config $config) {
		$options = array();
		$options['conditions'][] = array('board = ?', $config->getBoardRecord());
		parent::__construct($name, $config->getPostingsContainer()->getFilteredContainer($options));
		
		$this->config = $config;
	}
	
	public function init() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$options = array();
		$options['conditions'][] = array('board = ?', $this->config->getBoardRecord());
		if ($this->config->getIsGlobal()) {
			$options['conditions'][] = array('user_name = ?', $user->nameUncolored);
			$options['conditions'][] = array('round_number = ?', RAKUUN_ROUND_NAME);
		} else {
			$options['conditions'][] = array('user = ?', $user);
		}
		
		$lastVisit = $this->config->getVisitedContainer()->selectFirst($options);
		if (!$lastVisit)
			$lastVisit = new DB_Record();
			
		$showParam = $this->getModule()->getParam('show');
		// FIXME not cool. only works as long as the fw doesn't change how this works
		$pageParam = $this->getModule()->getParam($this->getName().'-page');
		if (!$pageParam && $showParam == 'recent') {
			$lastVisitTime = ($lastVisit) ? $lastVisit->date : time();
			$options = array();
			$options['conditions'][] = array('board = ?', $this->config->getBoardRecord());
			$options['conditions'][] = array('date < ?', $lastVisitTime);
			$olderPostsCount = $this->config->getPostingsContainer()->count($options);
			$pageNumber = ceil($olderPostsCount / $this->getItemsPerPage());
			$this->setPage($pageNumber);
		}
		
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/postingview.tpl');
		
		$mostRecentPost = null;
		if (!$lastVisit || $lastVisit->date < $this->config->getBoardRecord()->date) {
			$options = array();
			$options['order'] = 'date ASC';
			$options['conditions'][] = array('date >= ?', $lastVisit->date);
			$mostRecentPost = $this->getContainer()->selectFirst($options);
		}
		
		$lastVisit->board = $this->config->getBoardRecord();
		$lastVisit->date = time();
		if ($this->config->getIsGlobal()) {
			$lastVisit->userName = $user->nameUncolored;
			$lastVisit->roundNumber = RAKUUN_ROUND_NAME;
		} else {
			$lastVisit->user = $user;
		}
		$this->config->getVisitedContainer()->save($lastVisit);
		
		$options = $this->getOptions();
		$options['order'] = 'date ASC';
		$postings = $this->getContainer()->select($options);
		$this->addPanel($list = new GUI_Panel_List('board'));
		foreach ($postings as $posting) {
			$list->addItem($postingPanel = new Rakuun_Intern_GUI_Panel_Board_Posting('posting'.$posting->getPK(), $posting, $this->config));
			if ($mostRecentPost && $mostRecentPost->getPK() == $posting->getPK())
				$postingPanel->addClasses('rakuun_board_posting_mostrecent');
		}
		$this->params->boardname = $this->config->getBoardRecord()->name;
		if ($this->config->getBoardRecord()->closed)
			$this->addPanel(new GUI_Panel_Text('post', 'Geschlossen'));
		else
			$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_AddPost('post', $this->config));
		if ($this->config->getUserIsMod()) {
			$module = $this->getModule();
			if ($module->getParam('moderate') == $user->getPK())
				$this->addPanel(new GUI_Control_Link('moderatelink', '-zurück-', $module->getUrl(array('board' => $module->getParam('board')))));
			else
				$this->addPanel(new GUI_Control_Link('moderatelink', '-moderate-', $module->getUrl(array('board' => $module->getParam('board'), 'moderate' => $user->getPK()))));
		}
	}
}
?>