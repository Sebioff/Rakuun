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
		$reports = array();
		foreach ($spies as $spy) {
			if (self::hasPrivilegesToSeeReport($spy)) {
				$reports[] = $spy;
			}
		}
		return $reports;
	}
	
	public static function hasPrivilegesToSeeReport(DB_Record $report) {
		$actualUser = Rakuun_User_Manager::getCurrentUser();
		return ($report->user->getPK() == $actualUser->getPK()
			|| ($report->user->alliance !== null
				&& $actualUser->alliance !== null
				&& $report->user->alliance->getPK() == $actualUser->alliance->getPK()
				&& Rakuun_Intern_Alliance_Security::get()->hasPrivilege($actualUser, Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_REPORTS)
				)
		);
	}
}

?>