<?php

class Rakuun_Intern_GUI_Panel_User_Reports_Buildings extends Rakuun_Intern_GUI_Panel_User_Reports_Display {
	public function beforeInit() {
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