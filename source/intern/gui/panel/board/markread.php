<?php

class Rakuun_Intern_GUI_Panel_Board_MarkRead extends GUI_Panel {
	private $config = null;
	
	public function __construct($name, Board_Config $config, $title = '') {
		$this->config = $config;
		
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();
		
		$this->addPanel(new GUI_Control_SubmitButton('markread', 'Alle als gelesen markieren'));
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
?>