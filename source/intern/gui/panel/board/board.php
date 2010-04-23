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
		$options = array();
		$options['order'] = 'date DESC';
		$boards = $this->getContainer()->select(DB_Container::mergeOptions($this->getOptions(), $options));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_List('board', $this->config, $boards));
		$this->addPanel($blanko = new GUI_Panel('addboard'));
		$blanko->addPanel($name = new GUI_Control_TextBox('name', null, 'Boardname'));
		$name->addValidator(new GUI_Validator_Mandatory());
		$name->addValidator(new GUI_Validator_RangeLength(2, 25));
		$blanko->addPanel(new GUI_Control_SubmitButton('addboard', 'anlegen'));
		$this->addPanel($blanko = new GUI_Panel('markread'));
		$blanko->addPanel(new GUI_Control_SubmitButton('markread', 'Alle als gelesen markieren'));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_Search('suchen', $this->config));
	}
	
	public function onAddBoard() {
		if ($this->hasErrors())
			return;
		
		$board = $this->config->getBoardRecord();
		$board->name = $this->addboard->name->getValue();
		$board->date = time();
		$this->config->getBoardsContainer()->save($board);
		$this->addboard->name->resetValue();
		$this->getModule()->invalidate();
	}
	
	public static function getNewPostingsCount(DB_Container $boardsContainer = null, DB_Container $visitedContainer = null) {
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$_visited = $visitedContainer->select($options);
		$visited = array();
		foreach ($_visited as $visit) {
			$visited[$visit->board->getPK()] = $visit;
		}
		$boards = $boardsContainer->select();
		$count = 0;
		foreach ($boards as $board) {
			if (isset($visited[$board->getPK()]) && $visited[$board->getPK()]->date < $board->date)
				$count++;
			if (!isset($visited[$board->getPK()]))
				$count++;
		}
		return $count;
	}
	
	public function showPages() {
		return ($this->getPageCount() > 1 && Router::get()->getCurrentModule()->getParam('board') === null);
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
				$options['conditions'][] = array('user_name = ?', $user->name);
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

class Board_Config {
	private $boardsContainer = null;
	private $boardRecord = null;
	private $module = null;
	private $postingsContainer = null;
	private $postingRecord = null;
	private $visitedContainer = null;
	private $isGlobal = false;

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
}
?>