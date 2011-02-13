<?php

class Rakuun_Intern_GUI_Panel_Reports_ByMeta extends Rakuun_Intern_GUI_Panel_Reports_Base implements Scriptlet_Privileged {
	public function afterInit() {
		$meta = Rakuun_DB_Containers::getMetasContainer()->selectByPK((int)$this->getModule()->getParam('id'));
		if ($meta) {
			$options = array();
			$options['order'] = 'time ASC';
			$options['conditions'][] = array('spied_user IN ('.implode(', ', $meta->members).')');
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