<?php

/**
 * Panel to display the alliance account log
 */
class Rakuun_Intern_GUI_Panel_Alliance_Account_LogView extends GUI_Panel_PageView {
	
	public function __construct($name, $title = '') {		
		$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$logs = Rakuun_DB_Containers::getAlliancesAccountlogContainer()->getFilteredContainer($options);
		parent::__construct($name, $logs, $title);
		
		$this->setItemsPerPage(20);
	}
	
	public function init() {
		parent::init();
		
		$options['order'] = 'date DESC';
		$logs = $this->getContainer()->select(array_merge($options, $this->getOptions()));
		$table = new GUI_Panel_Table('table');
		$table->setAttribute('summary', 'Kontobewegungen');
		$table->addHeader(array('Sender', 'Empfänger', 'Eisen', 'Beryllium', 'Energie', 'Leute', 'Datum'));
		foreach ($logs as $log) {
			$sender = new Rakuun_GUI_Control_UserLink('userlink'.$log->getPK(), $log->sender);
			$receiver = isset($log->receiver) ? new Rakuun_GUI_Control_UserLink('receiverlink'.$log->getPK(), $log->receiver) : Rakuun_Intern_IGM::SENDER_ALLIANCE;
			$iron = new GUI_Panel_Number('iron'.$log->getPK(), $log->iron);
			$beryllium = new GUI_Panel_Number('beryllium'.$log->getPK(), $log->beryllium);
			$energy = new GUI_Panel_Number('energy'.$log->getPK(), $log->energy);
			$people = new GUI_Panel_Number('people'.$log->getPK(), $log->people);
			$date = new GUI_Panel_Date('date'.$log->getPK(), $log->date);
			if ($log->type == Rakuun_Intern_GUI_Panel_Alliance_Account::TYPE_ALLIANCE_TO_USER) {
				if ($log->iron > 0)
					$iron->setPrefix('-');
				if ($log->beryllium > 0)
					$beryllium->setPrefix('-');
				if ($log->energy > 0)
					$energy->setPrefix('-');
				if ($log->people > 0)
					$people->setPrefix('-');
			}			
			$table->addLine(array($sender, $receiver, $iron, $beryllium, $energy, $people, $date));
		}
		$this->addPanel($table);
	}
}

?>