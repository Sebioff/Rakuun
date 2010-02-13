<?php

/**
 * Displays information of a single board.
 */
class Rakuun_Intern_GUI_Panel_Board_Board extends GUI_Panel {
	private $board = null;
	
	public function __construct($name, DB_Record $board) {
		$this->board = $board;
		parent::__construct($name);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/board.tpl');
		$this->addPanel($link = new GUI_Control_Link('boardlink', $this->board->name, Router::get()->getCurrentModule()->getUrl(array('board' => $this->board->id))));
		$options['conditions'][] = array('board = ?', $this->board);
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$lastVisited = Rakuun_DB_Containers::getBoardsLastVisitedContainer()->selectFirst($options);
		$postings = Rakuun_DB_Containers::getBoardsPostingsContainer();
		$this->params->count = $postings->countByBoard($this->board);
		$posting = $postings->selectByBoardFirst($this->board, array('order' => 'date DESC'));
		if ($posting)
			$this->addPanel(new GUI_Panel_Date('date', $posting->date));
		if ($lastVisited === null || ($posting && ($posting->date > $lastVisited->date)))
			$link->setAttribute('style', 'font-weight:bold');
	}
}

?>