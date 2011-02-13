<?php

class Rakuun_Intern_GUI_Panel_Reports_ByMeta extends Rakuun_Intern_GUI_Panel_Reports_Base implements Scriptlet_Privileged {
	public function afterInit() {
		$options = array();
		$options['order'] = 'time ASC';
		$options['conditions'][] = array('user IN ('.implode(', ', Rakuun_User_Manager::getCurrentUser()->alliance->meta->members).')');
		$options['conditions'][] = array('deleted = ?', 0);
		foreach ($this->getFilterStrings() as $filterString) {
			if ($filterString)
				$options['conditions'][] = array($filterString);
		}
		$this->data = Rakuun_DB_Containers::getLogSpiesContainer()->select($options);
		
		parent::afterInit();
	}
	
	public function checkPrivileges() {
		$user = Rakuun_User_Manager::getCurrentUser();
		return ($user && $user->alliance && $user->alliance->meta);
	}
}
?>