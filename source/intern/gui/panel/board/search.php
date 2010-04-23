<?php

class Rakuun_Intern_GUI_Panel_Board_Search extends GUI_Panel {
	private $config = null;
	
	public function __construct($name, Board_Config $config, $title = '') {
		parent::__construct($name, $title);
		
		$this->config = $config;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/search.tpl');
		$this->addPanel($text = new GUI_Control_TextBox('board', '', 'Boardname'));
		$text->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('search', 'suchen'));
	}
	
	public function onSearch() {
		$options = array();
		$options['conditions'][] = array('`name` LIKE ?', '%'.str_replace('*', '%', $this->board->getValue()).'%');
		$options['order'] = 'name ASC, date DESC';
		$boards = $this->config->getBoardsContainer()->select($options);
		if (!empty($boards)) {
			$list = new GUI_Panel_List('result');
			$module = $this->getModule();
			foreach ($boards as $board) {
				$list->addItem(new GUI_Control_Link('board'.$board->getPK(), $board->name, $module->getUrl(array('board' => $board->getPK()))));
			}
			$this->addPanel($list);
		}
	}
}
?>