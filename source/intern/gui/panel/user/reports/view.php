<?php

class Rakuun_Intern_GUI_Panel_User_Reports_View extends Rakuun_Intern_GUI_Panel_User_Reports {
	public function init() {
		parent::init();
		
		$this->addPanel($table = new GUI_Panel_Table('reports'));
		$spies = $this->getReports();
		$units = Rakuun_Intern_Production_Factory::getAllUnits();
		$buildings = Rakuun_Intern_Production_Factory::getAllBuildings();
		$tableHeader = array('Datum', 'Angreifer');
		foreach ($units as $unit) {
			$tableHeader[] = $unit->getName();
		}
		foreach ($buildings as $building) {
			$tableHeader[] = $building->getName();
		}
		$table->addHeader($tableHeader);
		$actualUser = Rakuun_User_Manager::getCurrentUser();
		foreach ($spies as $spy) {
			$line = array();
			$line[] = date(GUI_Panel_Date::FORMAT_DATETIME, $spy->time);
			$line[] = new Rakuun_GUI_Control_UserLink('userlink'.$spy->getPK(), $spy->user);
			foreach ($units as $unit) {
				$line[] = $spy->{Text::underscoreToCamelCase($unit->getInternalName())};
			}
			foreach ($buildings as $building) {
				$line[] = $spy->{Text::underscoreToCamelCase($building->getInternalName())};
			}
			$table->addLine($line);
		}
	}
}
?>