<?php

class Rakuun_Intern_GUI_Panel_Reports_ForAlliance extends Rakuun_Intern_GUI_Panel_Reports_Base {
	public function afterInit() {
		$alliance = Rakuun_DB_Containers::getAlliancesContainer()->selectByPK((int)$this->getModule()->getParam('id'));
		if ($alliance) {
			$options = array();
			$options['order'] = 'time ASC';
			$options['conditions'][] = array('spied_user IN ('.implode(', ', $alliance->members).')');
			$options['conditions'][] = array('deleted = ?', 0);
			foreach ($this->getFilterStrings() as $filterString) {
				if ($filterString)
					$options['conditions'][] = array($filterString);
			}
			$this->data = Rakuun_DB_Containers::getLogSpiesContainer()->select($options);
		}
		
		parent::afterInit();
	}
}
?>