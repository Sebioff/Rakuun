<?php

/**
 * Displays all threads of a specific board.
 */
class Rakuun_Intern_GUI_Panel_Board_Postingview extends GUI_Panel {
	private $board = null;
	
	public function __construct($name, DB_Record $board) {
		$this->board = $board;
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('board = ?', $board);
		$lastVisit = Rakuun_DB_Containers::getBoardsLastVisitedContainer()->selectFirst($options);
		if (!$lastVisit)
			$lastVisit = new DB_Record();
		$lastVisit->user = Rakuun_User_Manager::getCurrentUser();
		$lastVisit->board = $board;
		$lastVisit->date = time();
		Rakuun_DB_Containers::getBoardsLastVisitedContainer()->save($lastVisit);
		
		parent::__construct($name);		
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/postingview.tpl');
		Rakuun_DB_Containers::getBoardsPostingsContainer()->addInsertCallback(array($this, 'onAddBoardPosting'));		
		$postings = Rakuun_DB_Containers::getBoardsPostingsContainer()->selectByBoard($this->board, array('order' => 'date ASC'));
		foreach ($postings as $posting) {
			$this->onAddBoardPosting($posting);			
		}
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_Addposting('addposting', $this->board));
		$this->params->boardname = $this->board->name;
	}
	
	public function onAddBoardPosting(DB_Record $posting) {
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_Posting('posting_'.$posting->getPK(), $posting));
	}
}

?>