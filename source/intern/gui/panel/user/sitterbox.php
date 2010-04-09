<?php

class Rakuun_Intern_GUI_Panel_User_Sitterbox extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/sitterbox.tpl');
		
		if (Rakuun_User_Manager::isSitting()) {
			$otherUser = Rakuun_User_Manager::getCurrentUser();
			$noteLabel = 'Nachricht an den Sittling';
		}
		else {
			$otherUser = Rakuun_User_Manager::getCurrentUser()->sitter;
			$noteLabel = 'Nachricht an den Sitter';
		}
		$this->addPanel($userLink = new Rakuun_GUI_Control_UserLink('sittername', $otherUser));
		$this->addPanel(new GUI_Control_TextArea('note', Rakuun_User_Manager::getCurrentUser()->sitterNote, $noteLabel));
		$this->addPanel($submitButton = new GUI_Control_SubmitButton('submit', 'Speichern'));
		$submitButton->addClasses('no_margin');
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
			
		$user = Rakuun_User_Manager::getCurrentUser();
		$user->sitterNote = $this->note;
		Rakuun_User_Manager::update($user);
	}
}

?>