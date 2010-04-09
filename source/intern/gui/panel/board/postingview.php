<?php

/**
 * Displays all threads of a specific board.
 */
class Rakuun_Intern_GUI_Panel_Board_PostingView extends GUI_Panel {
	private $board = null;
	private $postingsContainer = null;
	private $visitedContainer = null;
	
	public function __construct($name, DB_Record $board, DB_Container $postingsContainer, DB_Container $visitedContainer) {
		parent::__construct($name);
		
		$this->board = $board;
		$this->postingsContainer = $postingsContainer;
		$this->visitedContainer = $visitedContainer;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/postingview.tpl');
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('board = ?', $this->board);
		$lastVisit = $this->visitedContainer->selectFirst($options);
		if (!$lastVisit)
			$lastVisit = new DB_Record();
		$lastVisit->user = Rakuun_User_Manager::getCurrentUser();
		$lastVisit->board = $this->board;
		$lastVisit->date = time();
		$this->visitedContainer->save($lastVisit);
		
		$options = array();
		$options['conditions'][] = array('board = ?', $this->board);
		$options['order'] = 'date ASC';
		$postings = $this->postingsContainer->select($options);
		$this->addPanel($list = new GUI_Panel_List('board'));
		foreach ($postings as $posting) {
			$list->addItem($item = new Rakuun_Intern_GUI_Panel_Board_Posting('posting'.$posting->getPK(), $posting));
		}
		$this->params->boardname = $this->board->name;
		$this->addPanel($addPost = new Rakuun_Intern_GUI_Panel_Board_AddPost('post', $this->board, $this->postingsContainer));
	}
}
?>