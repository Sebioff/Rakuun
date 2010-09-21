<?php

/**
 * Displays all Userdata changes of a given user
 */
class Rakuun_Intern_GUI_Panel_Multihunting_UserdataLog extends GUI_Panel {
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		parent::__construct($name, $title);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/userdatalog.tpl');
		if ($this->user) {
			$this->addPanel($log = new GUI_Panel_Table('log', 'Userdaten'));
			$log->addHeader(array('Zeit', 'Aktion', 'Data', 'IP', 'Hostname', 'Browser'));
			$options = array();
			$options['order'] = 'time DESC';
			foreach (Rakuun_DB_Containers::getLogUserDataContainer()->selectByUser($this->user, $options) as $userdata) {
				$date = new GUI_Panel_Date('date'.$userdata->getPK(), $userdata->time);
				$log->addLine(array($date, Rakuun_Intern_Log::getActionDescription($userdata->action), $userdata->data, $userdata->ip, $userdata->hostname, $userdata->browser));
			}
		}
	}
}

?>