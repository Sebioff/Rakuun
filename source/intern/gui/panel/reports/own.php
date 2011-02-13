<?php

class Rakuun_Intern_GUI_Panel_Reports_Own extends Rakuun_Intern_GUI_Panel_Reports_Base {
	public function afterInit() {
		$options = array();
		$options['order'] = 'time ASC';
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('deleted = ?', 0);
		foreach ($this->getFilterStrings() as $filterString) {
			if ($filterString)
				$options['conditions'][] = array($filterString);
		}
		$this->data = Rakuun_DB_Containers::getLogSpiesContainer()->select($options);
		
		parent::afterInit();
	}
}
?>