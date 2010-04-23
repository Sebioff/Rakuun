<?php

/**
 * Displays form for adding a post
 */
class Rakuun_Intern_GUI_Panel_Board_AddPost extends GUI_Panel {
	private $config = null;
	
	public function __construct($name, Board_Config $config) {
		parent::__construct($name);
		
		$this->config = $config;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/addpost.tpl');
		
		$this->addPanel($text = new GUI_Control_TextArea('text', null, 'Posting'));
		$text->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'posten'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$posting = $this->config->getPostingRecord();
		$posting->board = $this->config->getBoardRecord();
		$posting->text = $this->text;
		$posting->date = time();
		$this->config->getPostingsContainer()->save($posting);
		$this->config->getBoardRecord()->date = time();
		$this->config->getBoardRecord()->save();
		DB_Connection::get()->commit();
		$this->text->resetValue();
		$this->getModule()->invalidate();
	}
}
?>