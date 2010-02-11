<?php

/**
 * Adds a new posting to a specific board.
 */
class Rakuun_Intern_GUI_Panel_Board_Addposting extends GUI_Panel {
	private $board = null;
	public function __construct($name, $board) {
		$this->board = $board;
		parent::__construct($name);
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/addposting.tpl');
		$this->addPanel($text = new GUI_Control_TextArea('text', null, 'Posting'));
		$text->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'posten'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
		
		$posting = new DB_Record();
		$posting->board = $this->board;
		$posting->user = Rakuun_User_Manager::getCurrentUser();
		$posting->text = $this->text;
		$posting->date = time();
		Rakuun_DB_Containers::getBoardsPostingsContainer()->save($posting);
	}
}

?>