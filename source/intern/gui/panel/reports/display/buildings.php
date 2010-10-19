<?php

class Rakuun_Intern_GUI_Panel_Reports_Display_Buildings extends Rakuun_Intern_GUI_Panel_Reports_Display {
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
			$buildings = Rakuun_Intern_Production_Factory::getAllBuildings();
			$data = array();
			$date = array();
			$i = 0;
			foreach ($reports as $report) {
				if (Rakuun_Intern_GUI_Panel_Reports_Base::hasPrivilegesToSeeReport($report)) {
					foreach ($buildings as $building) {
						$data['reports'][$building->getName()][$i] = $report->{Text::underscoreToCamelCase($building->getInternalName())};
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
	
	public function beforeInit_deprecated() {
		parent::beforeInit();
		
		$reports = $this->getReports();
		if (!empty($reports)) {
			$buildings = Rakuun_Intern_Production_Factory::getAllBuildings();
			$data = array();
			$date = array();
			foreach ($buildings as $building) {
				foreach ($reports as $report) {
					$data['reports'][$building->getName()][] = $report->{Text::underscoreToCamelCase($building->getInternalName())};
					$date[$report->time] = date(GUI_Panel_Date::FORMAT_DATE, $report->time);
				}
			}
			$data['date'] = $date;
			$this->setData($data);
		}
	}
}
?>