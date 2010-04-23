<?php

class Rakuun_Intern_GUI_Panel_Board_List extends GUI_Panel {
	private $boards = array();
	private $config = null;
	
	public function __construct($name, Board_Config $config, array $boards, $title = '') {
		parent::__construct($name, $title);
		
		$this->boards = $boards;
		$this->config = $config;
	}
	
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->addPanel($table = new GUI_Panel_Table('board'));
		$table->addHeader(array('Name', 'Beiträge', 'Letzte Änderung'));
		$module = $this->config->getBoardModule();
		foreach ($this->boards as $board) {
			$line = array();
			$link = new GUI_Control_Link('boardlink', $board->name, $module->getUrl(array('board' => $board->id)));
			$options = array();
			$options['conditions'][] = array('board = ?', $board);
			if ($this->config->getIsGlobal()) {
				$options['conditions'][] = array('user_name = ?', $user->nameUncolored);
				$options['conditions'][] = array('round_number = ?', RAKUUN_ROUND_NAME);
			} else {
				$options['conditions'][] = array('user = ?', $user);
			}
			$lastVisit = $this->config->getVisitedContainer()->selectFirst($options);
			if (!$lastVisit || $lastVisit->date < $board->date)
				$link->setAttribute('style', 'font-weight:bold');
			$line[] = $link;
			$line[] = $this->config->getPostingsContainer()->countByBoard($board);
			$line[] = new GUI_Panel_Date('date'.$board->getPK().$this->getName(), $board->date);
			$table->addLine($line);
		}
	}
}
?>