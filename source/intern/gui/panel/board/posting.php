<?php

/**
 * Displays a specific posting.
 */
class Rakuun_Intern_GUI_Panel_Board_Posting extends GUI_Panel {
	private $posting = null;
	private $config = null;
	
	public function __construct($name, DB_Record $posting, Board_Config $config) {
		parent::__construct($name);
		
		$this->posting = $posting;
		$this->config = $config;
	}
	
	public function init() {
		parent::init();
		 
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->setTemplate(dirname(__FILE__).'/posting.tpl');
		if ((Router::get()->getCurrentModule()->getParam('edit') == $this->posting->getPK()
			&& $this->posting->deleted == 0)		
			&& (($this->posting->user && $this->posting->user->getPK() == $user->getPK())
				|| ($this->posting->userName && $this->posting->userName == $user->nameUncolored && $this->posting->roundNumber == RAKUUN_ROUND_NAME))
		) {
			$this->addPanel($blanko = new GUI_Panel('form'));
			$blanko->addPanel($text = new GUI_Control_TextArea('text', $this->posting->text, 'Posting'));
			$text->addValidator(new GUI_Validator_Mandatory());
			$blanko->addPanel(new GUI_Control_SubmitButton('edit', 'speichern'));
		}
		$this->params->posting = $this->posting;
		$this->params->config = $this->config;
		
		$this->addPanel(new GUI_Panel_Date('date', $this->posting->date));
		if ($this->config->getIsGlobal()) {
			// posting is from global board
			if ($this->posting->roundNumber == RAKUUN_ROUND_NAME) {
				// user belongs to actual rakuun-round
				$postingUser = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($this->posting->userName);
				$this->addPanel(new Rakuun_GUI_Control_UserLink('user', $postingUser, $postingUser->getPK()));
			} else {
				// user belongs to historic rakuun-round
				$this->addPanel(new GUI_Panel_Text('user', $this->posting->userName.' ['.$this->posting->roundNumber.']'));
			}
		} else {
			$this->addPanel(new Rakuun_GUI_Control_Userlink('user', $this->posting->user, $this->posting->get('user')));
		}
		if ($this->posting->editdate)
			$this->addPanel(new GUI_Panel_Date('editdate', $this->posting->editdate));
		if ($this->posting->deleted == 0
			&& (($this->posting->user && $this->posting->user->getPK() == $user->getPK())
			|| ($this->posting->userName && $this->posting->userName == $user->nameUncolored && $this->posting->roundNumber == RAKUUN_ROUND_NAME))) 
		{
			$this->addPanel(new GUI_Control_Link('editlink', '-edit-', Router::get()->getCurrentModule()->getUrl(array('board' => $this->posting->board->getPK(), 'edit' => $this->posting->getPK()))));
		}
		if ($this->getModule()->getParam('moderate') == $user->getPK()) {
			$this->addPanel($deleteButton = new GUI_Control_SubmitButton('delete', 'Löschen'));
			$deleteButton->setConfirmationMessage('Das Posting von '.date(GUI_Panel_Date::FORMAT_DATETIME, $this->posting->date).' wirklich löschen?');
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
	
	public function onDelete() {
		if ($this->hasErrors())
			return;
		
		$this->posting->deleted = 1;
		if ($this->config->getIsGlobal()) {
			$this->posting->deletedByName = Rakuun_User_Manager::getCurrentUser()->nameUncolored;
			$this->posting->deletedByRoundNumber = RAKUUN_ROUND_NAME;
		} else {
			$this->posting->deletedBy = Rakuun_User_Manager::getCurrentUser();
		}
		$this->posting->save();
		$this->getModule()->redirect($this->getModule()->getUrl(array('board' => $this->posting->board)));
	}
	
	public function checkDisplayPosting() {
		if ($this->config->getIsGlobal()) {
			if (($this->params->posting->deleted == 1 && (($this->params->posting->userName == Rakuun_User_Manager::getCurrentUser()->nameUncolored && $this->params->posting->roundNumber == RAKUUN_ROUND_NAME) || $this->params->config->getUserIsMod()))
			|| $this->params->posting->deleted == 0)
				return true;
		} else {
			if (($this->params->posting->deleted == 1 && ($this->params->posting->user->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK() || $this->params->config->getUserIsMod()))
			|| $this->params->posting->deleted == 0)
				return true;
		}
		return false;
	}
}

?>