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
		$this->params->board = $this->board;
		$postings = Rakuun_DB_Containers::getBoardsPostingsContainer();
		$this->params->count = $postings->countByBoard($this->board);
		$posting = $postings->selectByBoardFirst($this->board, array('order' => 'date DESC'));
		if ($posting)
			$this->addPanel(new GUI_Panel_Date('date', $posting->date));
	}
}

?>