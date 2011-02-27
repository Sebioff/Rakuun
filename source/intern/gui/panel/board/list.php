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
		$module = $this->config->getBoardModule();
		$this->addPanel($table = new GUI_Panel_Table('board'));
		$header = array();
		$header[] = 'Name';
		$header[] = 'Beiträge';
		$header[] = 'Letzte Änderung';
		if ($module->getParam('moderate') == $user->getPK()) {
			$header[] = 'löschen';
			$this->addPanel(new GUI_Control_SubmitButton('edit', 'Namen speichern'));
		}
		$table->addHeader($header);
		foreach ($this->boards as $board) {
			$line = array();
			$options = array();
			$options['conditions'][] = array('board = ?', $board);
			if ($this->config->getIsGlobal()) {
				$options['conditions'][] = array('user_name = ?', $user->nameUncolored);
				$options['conditions'][] = array('round_number = ?', RAKUUN_ROUND_NAME);
			} else {
				$options['conditions'][] = array('user = ?', $user);
			}
			if ($module->getParam('moderate') == $user->getPK()) {
				$box = new GUI_Control_Textbox('boardname'.$board->getPK(), $board->name);
				$box->addValidator(new GUI_Validator_Mandatory());
				$box->addValidator(new GUI_Validator_RangeLength(2, 25));
				$line[] = $box;
			} else {
				$lastVisit = $this->config->getVisitedContainer()->selectFirst($options);
				
				$urlParams = array('board' => $board->id);
				if (!$lastVisit || $lastVisit->date < $board->date)
					$urlParams['show'] = 'recent';
				
				$link = new GUI_Control_Link('boardname'.$board->getPK(), $board->name, $module->getUrl($urlParams));
				if (!$lastVisit || $lastVisit->date < $board->date) {
					if ($this->config->getIsGlobal()) {
						$options = array();
						$options['conditions'][] = array('board = ?', $board);
						$options['conditions'][] = array('date >= ?', RAKUUN_ROUND_STARTTIME);
						if ($this->config->getPostingsContainer()->selectFirst($options))
							$link->setAttribute('style', 'font-weight:bold');
					} else {
						$link->setAttribute('style', 'font-weight:bold');
					}
				}
				$line[] = $link;
			}
			$line[] = $this->config->getPostingsContainer()->countByBoard($board);
			$line[] = new GUI_Panel_Date('date'.$board->getPK().$this->getName(), $board->date);
			if ($module->getParam('moderate') == $user->getPK()) {
				$blanko = new GUI_Panel('moderate'.$board->getPK());
				$blanko->addPanel($button = new GUI_Control_SubmitButton('delete', 'Löschen'));
				$button->addCallback(array($this, 'onDeleteCustom'), array($board));
				$button->setConfirmationMessage('Das Forum `'.$board->name.'` wirklich löschen?');
				$blanko->addPanel(new GUI_Control_HiddenBox('board', $board->getPK()));
				$line[] = $blanko;
			}
			$table->addLine($line);
		}
	}
	
	public function onEdit() {
		if ($this->hasErrors())
			return;
		
		foreach ($this->boards as $board) {
			if ($board->name != $this->board->{'boardname'.$board->getPK()}->getValue()) {
				$board->name = $this->board->{'boardname'.$board->getPK()}->getValue();
				$board->date = time();
				$board->save();
			}
		}
		$this->getModule()->invalidate();
	}
	
	public function onDeleteCustom($board) {
		if ($this->getModule()->getParam('moderate') != Rakuun_User_Manager::getCurrentUser()->getPK() || $this->hasErrors())
			return;
		
		$board->delete();
		$this->getModule()->invalidate();
	}
}
?>