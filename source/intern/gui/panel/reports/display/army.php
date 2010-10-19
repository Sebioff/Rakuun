<?php

class Rakuun_Intern_GUI_Panel_Reports_Display_Army extends Rakuun_Intern_GUI_Panel_Reports_Display {
	private $user;
	
	public function __construct($name, Rakuun_DB_User $user, $title = '') {
		parent::__construct($name, $title);
		
		$this->user = $user;
	}
	
	public function init() {
		$options = array();
		$options['conditions'][] = array('spied_user = ?', $this->user);
		$options['conditions'][] = array('deleted = ?', 0);
		$options['order'] = 'time ASC';
		$reports = Rakuun_DB_Containers::getLogSpiesContainer()->select($options);
		if (!empty($reports)) {
			$units = Rakuun_Intern_Production_Factory::getAllUnits();
			$data = array();
			$date = array();
			$i = 0;
			foreach ($reports as $report) {
				if (Rakuun_Intern_GUI_Panel_Reports_Base::hasPrivilegesToSeeReport($report)) {
					foreach ($units as $unit) {
						$data['reports'][$unit->getName()][$i] = $report->{Text::underscoreToCamelCase($unit->getInternalName())};
						$date[$report->time] = date(GUI_Panel_Date::FORMAT_DATE, $report->time);
					}
					$i++;
				}
			}
			$data['date'] = $date;
			$this->setData($data);
		}
		
		parent::init();
	}
}
?>