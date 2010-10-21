<?php

class Rakuun_Intern_GUI_Panel_Reports_ByMeta extends Rakuun_Intern_GUI_Panel_Reports_Base implements Scriptlet_Privileged {
	public function beforeDisplay() {
		$options = array();
		$options['order'] = 'time ASC';
		$options['conditions'][] = array('user IN ('.implode(', ', Rakuun_User_Manager::getCurrentUser()->alliance->meta->members).')');
		$options['conditions'][] = array('deleted = ?', 0);
		$filterString = $this->getFilterStrings();
		if ($filterString['filter'])
			$options['conditions'][] = array($filterString['filter']);
		if ($filterString['filter1'])
			$options['conditions'][] = array($filterString['filter1']);
		$this->data = Rakuun_DB_Containers::getLogSpiesContainer()->select($options);
		
		parent::beforeDisplay();
	}
	
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user && $user->alliance && $user->alliance->meta);
	}
}
?>