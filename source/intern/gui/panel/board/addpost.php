<?php

/**
 * Displays form for adding a post
 */
class Rakuun_Intern_GUI_Panel_Board_AddPost extends GUI_Panel {
	private $board = null;
	private $postingsContainer = null;
	
	public function __construct($name, DB_Record $board, DB_Container $postingsContainer) {
		parent::__construct($name);
		
		$this->board = $board;
		$this->postingsContainer = $postingsContainer;
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
		$posting = new DB_Record();
		$posting->board = $this->board;
		$posting->user = Rakuun_User_Manager::getCurrentUser();
		$posting->text = $this->text;
		$posting->date = time();
		$this->postingsContainer->save($posting);
		$this->board->date = time();
		$this->board->save();
		DB_Connection::get()->commit();
		$this->text->resetValue();
		$this->getModule()->invalidate();
	}
}
?>