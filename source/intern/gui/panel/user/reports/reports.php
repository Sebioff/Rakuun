<?php

abstract class Rakuun_Intern_GUI_Panel_User_Reports extends GUI_Panel {
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user, $title = '') {
		parent::__construct($name, $title);
		
		$this->user = $user;
		
		if ($this->getModule()->getParam('delete')) {
			$reportToDelete = Rakuun_DB_Containers::getLogSpiesContainer()->selectByPK($this->getModule()->getParam('delete'));
			if ($reportToDelete && $reportToDelete->user->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK()) {
				$reportToDelete->deleted = 1;
				Rakuun_DB_Containers::getLogSpiesContainer()->save($reportToDelete);
			}
		}
	}
	
	protected function getReports() {
		$options = array();
		$options['conditions'][] = array('spied_user = ?', $this->user);
		$options['conditions'][] = array('deleted = ?', 0);
		$options['order'] = 'TIME ASC';
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
		if ($report->user->getPK() == $actualUser->getPK())
			return true;
		if ($report->user->alliance !== null && $actualUser->alliance !== null && Rakuun_Intern_Alliance_Security::get()->hasPrivilege($actualUser, Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_REPORTS)) {
			if ($report->user->alliance->getPK() == $actualUser->alliance->getPK())
				return true;
			if ($report->user->alliance->meta !== null && $actualUser->alliance->meta !== null) {
				if ($report->user->alliance->meta->getPK() == $actualUser->alliance->meta->getPK())
					return true;
			}
		}
		return false;
	}
}

?>