<?php

class Rakuun_Intern_GUI_Panel_Reports_ForUser extends Rakuun_Intern_GUI_Panel_Reports_Base {
	private $user;
	
	public function __construct($name, Rakuun_DB_User $user, $title = '') {
		parent::__construct($name, $title);
		
		$this->user = $user;
	}
	
	public function init() {
		$options = array();
		$options['conditions'][] = array('spied_user = ?', $this->user);
		$options['conditions'][] = array('deleted = ?', 0);
		$options['order'] = 'time ASC';
		$this->data = Rakuun_DB_Containers::getLogSpiesContainer()->select($options);
		
		parent::init();
	}
}
?>