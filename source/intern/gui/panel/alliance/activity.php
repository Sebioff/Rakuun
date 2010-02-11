<?php

/**
 * Display the last activity of each alliance member.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Activity extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/activity.tpl');
		$options['order'] = 'last_activity DESC';
		$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$members = Rakuun_DB_Containers::getUserContainer()->select($options);
		$this->addPanel($table = new GUI_Panel_Table('table'));
		$table->enableSortable();
		$table->addHeader(array('Name', 'Letzte Aktivität'));
		foreach ($members as $member) {
			$table->addLine(
				array(
					new Rakuun_GUI_Control_UserLink('userlink'.$member->getPK(), $member), 
					new GUI_Panel_Date('date'.$member->getPK(), $member->lastActivity)
				)
			);
		}
		$table->setAttribute('summary', 'Member Aktivitätsübersicht');
	}
}

?>