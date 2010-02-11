<?php

/**
 * Panel to delete users
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_User_Delete extends GUI_Panel {
	// user to delete
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null) {
		parent::__construct($name);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/delete.tpl');

		$this->addPanel($user = new Rakuun_GUI_Control_UserSelect('deleteuser', $this->user, 'User'));
		$user->addValidator(new GUI_Validator_Mandatory());
		$this->addPanel(new GUI_Control_SecureSubmitButton('delete', 'User löschen'));
	}
	
	public function onDelete() {
		$user = $this->deleteuser->getUser();

		if (!$user || $this->hasErrors()) {
			return;
		}
		
		Rakuun_DB_Containers::getUserContainer()->delete($user);
	}
}

?>