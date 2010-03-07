<?php

/**
 * Displays a specific posting.
 */
class Rakuun_Intern_GUI_Panel_Board_Posting extends GUI_Panel {
	private $posting = null;
	
	public function __construct($name, DB_Record $posting) {
		parent::__construct($name);
		$this->posting = $posting;
	}
	
	public function init() {
		parent::init();
		 
		$this->setTemplate(dirname(__FILE__).'/posting.tpl');
		if (Router::get()->getCurrentModule()->getParam('edit') == $this->posting->getPK()
			&& Rakuun_User_Manager::getCurrentUser()->getPK() == $this->posting->user->getPK()
		) {
			$this->addPanel($blanko = new GUI_Panel('form'));
			$blanko->addPanel($text = new GUI_Control_TextArea('text', $this->posting->text, 'Posting'));
			$text->addValidator(new GUI_Validator_Mandatory());
			$blanko->addPanel(new GUI_Control_SubmitButton('edit', 'speichern'));
		}
		$this->params->posting = $this->posting;
		$this->addPanel(new GUI_Panel_Date('date', $this->posting->date));
		$this->addPanel(new Rakuun_GUI_Control_Userlink('user', $this->posting->user, $this->posting->get('user')));
		if ($this->posting->editdate)
			$this->addPanel(new GUI_Panel_Date('editdate', $this->posting->editdate));
		if ($this->posting->user && $this->posting->user->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK()) {
			$this->addPanel(new GUI_Control_Link('editlink', '-edit-', Router::get()->getCurrentModule()->getUrl(array('board' => $this->posting->board->getPK(), 'edit' => $this->posting->getPK()))));
		}
	}
	
	public function onEdit() {
		if ($this->hasErrors())
			return;
		
		$this->posting->text = $this->form->text->getValue();
		$this->posting->editdate = time();
		$this->posting->save();
		$this->getModule()->redirect($this->getModule()->getUrl(array('board' => $this->posting->board)));
	}
}

?>