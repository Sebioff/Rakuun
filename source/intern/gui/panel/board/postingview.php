<?php

/**
 * Displays all threads of a specific board.
 */
class Rakuun_Intern_GUI_Panel_Board_PostingView extends GUI_Panel_PageView {
	private $config = null;
	
	public function __construct($name, Board_Config $config) {
		$options = array();
		$options['conditions'][] = array('board = ?', $config->getBoardRecord());
		parent::__construct($name, $config->getPostingsContainer()->getFilteredContainer($options));
		
		$this->config = $config;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/postingview.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();
		$options = array();
		$options['conditions'][] = array('board = ?', $this->config->getBoardRecord());
		if ($this->config->getIsGlobal()) {
			$options['conditions'][] = array('user_name = ?', $user->nameUncolored);
			$options['conditions'][] = array('round_number = ?', RAKUUN_ROUND_NAME);
		} else {
			$options['conditions'][] = array('user = ?', $user);
		}
		$lastVisit = $this->config->getVisitedContainer()->selectFirst($options);
		if (!$lastVisit)
			$lastVisit = new DB_Record();
		$lastVisit->board = $this->config->getBoardRecord();
		$lastVisit->date = time();
		if ($this->config->getIsGlobal()) {
			$lastVisit->userName = $user->nameUncolored;
			$lastVisit->roundNumber = RAKUUN_ROUND_NAME;
		} else {
			$lastVisit->user = $user;
		}
		$this->config->getVisitedContainer()->save($lastVisit);
		
		$options = $this->getOptions();
		$options['order'] = 'date DESC';
		$postings = $this->getContainer()->select($options);
		$this->addPanel($list = new GUI_Panel_List('board'));
		foreach ($postings as $posting) {
			$list->addItem(new Rakuun_Intern_GUI_Panel_Board_Posting('posting'.$posting->getPK(), $posting, $this->config));
		}
		$this->params->boardname = $this->config->getBoardRecord()->name;
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_AddPost('post', $this->config));
		if ($this->config->getUserIsMod()) {
			$module = $this->getModule();
			if ($module->getParam('moderate') == $user->getPK())
				$this->addPanel(new GUI_Control_Link('moderatelink', '-zurück-', $module->getUrl(array('board' => $module->getParam('board')))));
			else
				$this->addPanel(new GUI_Control_Link('moderatelink', '-moderate-', $module->getUrl(array('board' => $module->getParam('board'), 'moderate' => $user->getPK()))));
		}
	}
}
?>