<?php

/**
 * Displays all or one specific board.
 */
class Rakuun_Intern_GUI_Panel_Board extends GUI_Panel_PageView {
	public function __construct($name, DB_Container $container = null, $title = '') {
		$this->setItemsPerPage(10);
		if ($container === null)
			$container = Rakuun_DB_Containers::getBoardsContainer();
			
		parent::__construct($name, $container, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/board.tpl');
		if (($boardId = Router::get()->getCurrentModule()->getParam('board')) > 0) {
			// Board darstellen
			$board = $this->getContainer()->selectByIdFirst($boardId);
			if ($board === null) {
				$this->addError('Du hast keinen Zugriff auf das Forum mit der ID '.$boardId);
				return;
			}
			$this->initWithSingleBoard($board);
		} else {
			$this->initWithBoards();
		}
	}
	
	protected function initWithSingleBoard(DB_Record $board) {
		$this->addPanel(
			new Rakuun_Intern_GUI_Panel_Board_PostingView(
				'board',
				$board,
				$this->getPostingsContainer(),
				$this->getVisitedContainer()
			)
		);
	}
	
	private function initWithBoards() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$options = array();
		$options['order'] = 'date DESC';
		$boards = $this->getContainer()->select(DB_Container::mergeOptions($this->getOptions(), $options));
		$this->addPanel($table = new GUI_Panel_Table('board'));
		$table->addHeader(array('Name', 'Beiträge', 'Letzte Änderung'));
		$module = Router::get()->getCurrentModule();
		foreach ($boards as $board) {
			$line = array();
			$link = new GUI_Control_Link('boardlink', $board->name, $module->getUrl(array('board' => $board->id)));
			$options = array();
			$options['conditions'][] = array('user = ?', $user);
			$options['conditions'][] = array('board = ?', $board);
			$lastVisit = $this->getVisitedContainer()->selectFirst($options);
			if (!$lastVisit || $lastVisit->date < $board->date)
				$link->setAttribute('style', 'font-weight:bold');
			$line[] = $link;
			$line[] = $this->getPostingsContainer()->countByBoard($board);
			$line[] = new GUI_Panel_Date('date'.$board->getPK(), $board->date);
			$table->addLine($line);
		}
		$this->addPanel($blanko = new GUI_Panel('addboard'));
		$blanko->addPanel($name = new GUI_Control_TextBox('name', null, 'Boardname'));
		$name->addValidator(new GUI_Validator_Mandatory());
		$name->addValidator(new GUI_Validator_RangeLength(2, 25));
		$blanko->addPanel(new GUI_Control_SubmitButton('addboard', 'anlegen'));
		$this->addPanel($blanko = new GUI_Panel('markread'));
		$blanko->addPanel(new GUI_Control_SubmitButton('markread', 'Alle als gelesen markieren'));
	}
	
	public function onAddBoard() {
		if ($this->hasErrors())
			return;
		
		$board = $this->getFilteredRecord();
		$board->name = $this->addboard->name->getValue();
		$board->date = time();
		$this->getContainer()->save($board);
		$this->addboard->name->resetValue();
		$this->getModule()->invalidate();
	}
	
	protected function getFilteredRecord() {
		return new DB_Record();
	}
	
	public static function getNewPostingsCount(DB_Container $boardsContainer = null, DB_Container $visitedContainer = null) {
		if ($boardsContainer === null)
			$boardsContainer = Rakuun_DB_Containers::getBoardsContainer();
		if ($visitedContainer === null)
			$visitedContainer = Rakuun_DB_Containers::getBoardsLastVisitedContainer();
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
	
	public function onMarkRead() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$lastVisitedContainer = $this->getVisitedContainer();
		$boards = $this->getBoardsContainer()->select();
		DB_Connection::get()->beginTransaction();
		foreach ($boards as $board) {
			$options = array();
			$options['conditions'][] = array('board = ?', $board);
			$options['conditions'][] = array('user = ?', $user);
			$newVisit = $lastVisitedContainer->selectFirst($options);
			if ($newVisit === null)
				$newVisit = new DB_Record();
			$newVisit->board = $board;
			$newVisit->user = $user;
			$newVisit->date = time();
			$lastVisitedContainer->save($newVisit);
		}
		DB_Connection::get()->commit();
		$this->getModule()->invalidate();
	}
	
	protected function getBoardsContainer() {
		return $this->getContainer();
	}
	
	protected function getPostingsContainer() {
		return Rakuun_DB_Containers::getBoardsPostingsContainer();
	}
	
	protected function getVisitedContainer() {
		return Rakuun_DB_Containers::getBoardsLastVisitedContainer();
	}
}
?>