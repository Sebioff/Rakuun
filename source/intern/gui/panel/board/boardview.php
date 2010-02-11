<?php

/**
 * Displays all boards.
 */
class Rakuun_Intern_GUI_Panel_Board_Boardview extends GUI_Panel {
	/**
	 * HINT: to add another boardtype you have to go through this points:
	 * - add new const TYPE_...
	 * - edit self::showBoard()
	 * - edit self::showForum()
	 * - edit Rakuun_Intern_GUI_Panel_Board_Addboard::onSubmit()
	 */	
	const TYPE_ALLIANCE = 1;
	const TYPE_META = 2;
	const TYPE_ADMIN = 3;
	
	protected $current = null;
	private $boardtype = null;
	
	public function __construct($name, $type, $title = '') {
		$this->boardtype = $type;
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		$this->current = Router::get()->getCurrentModule();
		if (($boardId = $this->current->getParam('board')) > 0) {
			// Board darstellen
			$this->showBoard($boardId);
		} else {
			$this->showForum();
		}
	}
	
	protected function showBoard($boardId) {
		$this->setTemplate(dirname(__FILE__).'/boardview.tpl');
		switch ($this->boardtype) {
			case self::TYPE_ALLIANCE: 
				$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
				$options['conditions'][] = array('type = ?', self::TYPE_ALLIANCE);
				$board = Rakuun_DB_Containers::getBoardsContainer()->selectByIdFirst($boardId, $options);
			break;
			case self::TYPE_META:
				$options['conditions'][] = array('meta = ?', Rakuun_User_Manager::getCurrentUser()->alliance->meta);
				$options['conditions'][] = array('type = ?', self::TYPE_META);
				$board = Rakuun_DB_Containers::getBoardsContainer()->selectByIdFirst($boardId, $options);
			break;
			case self::TYPE_ADMIN:
				$options['conditions'][] = array('type = ?', self::TYPE_ADMIN);
				$board = Rakuun_DB_Containers::getBoardsContainer()->selectByIdFirst($boardId, $options);
			break;
			default:
				$this->addError('Unbekannter Boardtype: '.$this->boardtype);
				return;
			break;
		}		
		if (!$board) {
			$this->addError('Du hast keinen Zugriff auf das Forum mit der ID '.$boardId);
			return;
		}
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_Postingview('board', $board));
		$this->params->boardname = 'board';
	}
	
	protected function showForum() {		
		$this->setTemplate(dirname(__FILE__).'/boardview.tpl');
		Rakuun_DB_Containers::getBoardsContainer()->addInsertCallback(array($this, 'onAddBoard'));
		switch ($this->boardtype) {
			case self::TYPE_ALLIANCE: 
				$boards = Rakuun_DB_Containers::getBoardsContainer()->selectByAlliance(Rakuun_User_Manager::getCurrentUser()->alliance);
			break;
			case self::TYPE_META:
				$boards = Rakuun_DB_Containers::getBoardsContainer()->selectByMeta(Rakuun_User_Manager::getCurrentUser()->alliance->meta);
			break;
			case self::TYPE_ADMIN: 
				$boards = Rakuun_DB_Containers::getBoardsContainer()->selectByType(self::TYPE_ADMIN);
			break;
			default:
				$this->addError('Fehlerhafter Boardtype: '.$this->boardtype);
				return;
			break;
		}		
		$postings = Rakuun_DB_Containers::getBoardsPostingsContainer()->select(array('order' => 'date DESC'));//, 'group' => 'board'));
		if ($postings && $boards) {
			$order = new DB_Order($boards, $postings);
			$boards = $order->desc();
		}
		foreach ($boards as $board) {
			$this->onAddBoard($board);
		}
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_Addboard('addboard', $this->boardtype), 'Board hinzufügen');
	}
	
	public static function getNewPostingsCount($boardtype = 0) {
		$user = Rakuun_User_Manager::getCurrentUser();
		$boardsContainer = Rakuun_DB_Containers::getBoardsContainer();
		$postingsContainer = Rakuun_DB_Containers::getBoardsPostingsContainer();
		$lastVisitedContainer = Rakuun_DB_Containers::getBoardsLastVisitedContainer();
		$boards = array();
		switch ($boardtype) {
			case self::TYPE_ALLIANCE:
				$boards = $boardsContainer->selectByType(self::TYPE_ALLIANCE, array('conditions' => array(array('alliance = ?', $user->alliance))));
			break;
			case self::TYPE_META:
				$boards = $boardsContainer->selectByType(self::TYPE_META, array('conditions' => array(array('meta = ?', $user->alliance->meta))));
			break;
			case self::TYPE_ADMIN:
				$boards = $boardsContainer->selectByType(self::TYPE_ADMIN);
			break;
		}
		$count = 0;
		foreach ($boards as $board) {
			$options = array();
			$options['order'] = 'date DESC';
			$options['conditions'][] = array('board = ?', $board);
			$visitedOptions = array();
			$visitedOptions['conditions'][] = array('board = ?', $board);
			$visitedOptions['conditions'][] = array('user = ?', $user);
			$lastVisited = $lastVisitedContainer->selectFirst($visitedOptions);
			$posting = $postingsContainer->selectFirst($options);
			if ($lastVisited == null || ($posting && $posting->date > $lastVisited->date)) {
				$count++;
			}
		}
		return $count;
	}
	
	// CALLBACKS ---------------------------------------------------------------
	public function onAddBoard(DB_Record $board) {
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_Board('board_'.$board->getPK(), $board));
	}
}

?>