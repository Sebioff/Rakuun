<?php

/**
 * Displays a specific posting.
 */
class Rakuun_Intern_GUI_Panel_Board_Posting extends GUI_Panel {
	private $posting = null;
	
	public function __construct($name, DB_Record $posting) {
		$this->posting = $posting;
		parent::__construct($name);		
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/posting.tpl');
		if (Router::get()->getCurrentModule()->getParam('edit') == $this->posting->getPK()
			&& Rakuun_User_Manager::getCurrentUser() == $this->posting->user
		) {
			$this->addPanel($text = new GUI_Control_TextArea('text', $this->posting->text, 'Posting'));
			$text->addValidator(new GUI_Validator_Mandatory());
			$this->addPanel(new GUI_Control_SubmitButton('submit', 'speichern'));
		}
		$this->params->posting = $this->posting;
		$this->addPanel(new GUI_Panel_Date('date', $this->posting->date));
		$this->addPanel(new Rakuun_GUI_Control_Userlink('user', $this->posting->user));
		if ($this->posting->editdate) 
			$this->addPanel(new GUI_Panel_Date('editdate', $this->posting->editdate));
		if ($this->posting->user == Rakuun_User_Manager::getCurrentUser()) {
			$this->addPanel(new GUI_Control_Link('editlink', '-edit-', Router::get()->getCurrentModule()->getUrl(array('board' => $this->posting->board->getPK(), 'edit' => $this->posting->getPK()))));
		}
	}
	
	public function onSubmit() {
		if ($this->hasErrors()) 
			return;
		
		$this->posting->text = $this->text->getValue();
		$this->posting->editdate = time();
		Rakuun_DB_Containers::getBoardsPostingsContainer()->save($this->posting);
	}
}

?>