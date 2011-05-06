<?php

class Rakuun_Intern_GUI_Panel_Reports_ForUser extends Rakuun_Intern_GUI_Panel_Reports_Base {
	private $user;
	
	public function __construct($name, Rakuun_DB_User $user, Rakuun_GUI_Panel_Box $detailBox, $title = '') {
		parent::__construct($name, $detailBox, $title);
		
		$this->user = $user;
	}
	
	public function afterInit() {
		$options = array();
		$options['conditions'][] = array('spied_user = ?', $this->user);
		$options['conditions'][] = array('deleted = ?', 0);
		$options['order'] = 'time DESC';
		$options['limit'] = Rakuun_Intern_GUI_Panel_Reports_Base::MAX_REPORTS_TO_LOAD;
		$this->data = Rakuun_DB_Containers::getLogSpiesContainer()->select($options);
		
		parent::afterInit();
	}
}
?>