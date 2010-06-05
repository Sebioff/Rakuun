<?php

class Rakuun_Intern_GUI_Panel_User_Reports_Army extends Rakuun_Intern_GUI_Panel_User_Reports_Display {
	public function init() {
		$reports = $this->getReports();
		if (!empty($reports)) {
			$units = Rakuun_Intern_Production_Factory::getAllUnits();
			$data = array();
			$date = array();
			foreach ($units as $unit) {
				foreach ($reports as $report) {
					$data['reports'][$unit->getName()][] = $report->{Text::underscoreToCamelCase($unit->getInternalName())};
					$date[$report->time] = date(GUI_Panel_Date::FORMAT_DATE, $report->time);
				}
			}
			$data['date'] = $date;
			$this->setData($data);
		}
		
		parent::init();
	}
}
?>