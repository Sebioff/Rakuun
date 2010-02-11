<?php

class Rakuun_Intern_GUI_Panel_Profile_Options extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/options.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->addPanel(new GUI_Control_CheckBox('tutorial', 1, (bool)$user->tutorial, 'Zeige Tutorial'));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'Speichern'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
			
		$user = Rakuun_User_Manager::getCurrentUser();
		$user->tutorial = (bool)$this->tutorial->getSelected();
		Rakuun_User_Manager::update($user);
		$this->setSuccessMessage('gespeichert');
	}
}
?>