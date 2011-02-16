<?php

/**
 * Displays all activities of a given user
 */
class Rakuun_Intern_GUI_Panel_Multihunting_ActivityLog extends GUI_Panel {
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		parent::__construct($name, $title);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/activitylog.tpl');
		if ($this->user) {
			$this->addPanel($log = new GUI_Panel_Table('log', 'Aktivität'));
			$log->addHeader(array('Aktion', 'Zeit', 'Cookie', 'IP', 'Hostname', 'Browser'));
			$options = array();
			$options['order'] = 'time DESC';
			foreach (Rakuun_DB_Containers::getLogUserActivityContainer()->selectByUser($this->user, $options) as $activity) {
				$date = new GUI_Panel_Date('date'.$activity->getPK(), $activity->time);
				$ip = new GUI_Control_Link('url'.$activity->getPK(), $activity->ip, Rakuun_Intern_Log::IPWHOIS.$activity->ip);
				$log->addLine(array(Rakuun_Intern_Log::getActionDescription($activity->action), $date, $activity->cookie, $ip, $activity->hostname, $activity->browser));
			}
		}
	}
}

?>