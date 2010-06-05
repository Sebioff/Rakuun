<?php

abstract class Rakuun_Intern_GUI_Panel_User_Reports extends GUI_Panel {
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user, $title = '') {
		parent::__construct($name, $title);
		
		$this->user = $user;
	}
	
	protected function getReports() {
		$options = array();
		$options['conditions'][] = array('spied_user = ?', $this->user);
		$options['order'] = 'TIME DESC';
		$spies = Rakuun_DB_Containers::getLogSpiesContainer()->select($options);
		$actualUser = Rakuun_User_Manager::getCurrentUser();
		$reports = array();
		foreach ($spies as $spy) {
			if ($spy->user->getPK() == $actualUser->getPK() 
			|| ($spy->user->alliance !== null
				&& $actualUser->alliance !== null
				&& $spy->user->alliance->getPK() == $actualUser->alliance->getPK()
				&& Rakuun_Intern_Alliance_Security::get()->hasPrivilege($actualUser, Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_REPORTS))
			) {
				$reports[] = $spy;
			}
		}
		return $reports;
	}
}
?>