<?php

/**
 * Displays all multi-activities of a given user
 */
class Rakuun_Intern_GUI_Panel_Multihunting_MultiActionLog extends GUI_Panel {
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		parent::__construct($name, $title);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/multiactionlog.tpl');
		if ($this->user) {
			$this->addPanel($log = new GUI_Panel_Table('log', 'Multi-Aktivität'));
			$log->addHeader(array('Zeit', 'User', 'Übereinstimmung', 'Aktion'));
			$i = 0;
			foreach (Rakuun_DB_Containers::getLogMultiactionsUsersAssocContainer()->selectByUser($this->user) as $activity) {
				foreach (Rakuun_DB_Containers::getLogMultiactionsUsersAssocContainer()->selectByMultiAction($activity->multiAction) as $action) {
					if ($activity->user != $action->user) {
						$date = new GUI_Panel_Date('date'.$i++, $action->multiAction->time);
						$log->addLine(array($date, $action->user->name, Rakuun_Intern_Log::getMultiActionDescription($action->multiAction->multiaction), Rakuun_Intern_Log::getActionDescription($action->multiAction->action)));
					}
				}
			}
		}
	}
}

?>