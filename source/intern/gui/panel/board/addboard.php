<?php

class Rakuun_Intern_GUI_Panel_Board_AddBoard extends GUI_Panel {
	private $config = null;
	
	public function __construct($name, Board_Config $config, $title = '') {
		$this->config = $config;
		
		parent::__construct($name, $title);
	}
	
	public function init() {
		parent::init();

		$this->setTemplate(dirname(__FILE__).'/addboard.tpl');
		
		$this->addPanel($name = new GUI_Control_TextBox('name', null, 'Boardname'));
		$name->addValidator(new GUI_Validator_Mandatory());
		$name->addValidator(new GUI_Validator_RangeLength(2, 25));
		$this->addPanel(new GUI_Control_SubmitButton('addboard', 'anlegen'));
	}
	
	public function onAddBoard() {
		if ($this->hasErrors())
			return;
		
		$board = $this->config->getBoardRecord();
		$board->name = Text::escapeHTML($this->name->getValue());
		$board->date = time();
		$this->config->getBoardsContainer()->save($board);
		$this->name->resetValue();
		$this->getModule()->invalidate();
	}
}
?>