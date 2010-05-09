<?php

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
	
//	public static function getNewPostingsCount(DB_Container $boardsContainer = null, DB_Container $visitedContainer = null) {
//		$options = array();
//		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
//		$_visited = $visitedContainer->select($options);
//		$visited = array();
//		foreach ($_visited as $visit) {
//			$visited[$visit->board->getPK()] = $visit;
//		}
//		$boards = $boardsContainer->select();
//		$count = 0;
//		foreach ($boards as $board) {
//			if (isset($visited[$board->getPK()]) && $visited[$board->getPK()]->date < $board->date)
//				$count++;
//			if (!isset($visited[$board->getPK()]))
//				$count++;
//		}
//		return $count;
//	}
	
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