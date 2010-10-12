<?php

abstract class Rakuun_Intern_GUI_Panel_Board_Overview_Base extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/base.tpl');
	}
	
	protected function getBoards(DB_Container $visitedContainer, DB_Container $boardsContainer) {
		$_visited = $visitedContainer->select();
		$visited = array();
		foreach ($_visited as $v) {
			$visited[$v->board->getPK()] = $v;
		}
		$options = array();
		$options['order'] = 'date DESC';
		$_boards = $boardsContainer->select($options);
		$boards = array();
		foreach ($_boards as $board) {
			if (isset($visited[$board->getPK()]) && $visited[$board->getPK()]->date < $board->date)
				$boards[] = $board;
			if (!isset($visited[$board->getPK()]))
				$boards[] = $board;
		}
		return $boards;
	}
}
?>