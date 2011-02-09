<?php

abstract class Rakuun_Intern_GUI_Panel_Reports_Base extends GUI_Panel {
	protected $data = array();
	protected $filter = array();
	
	public function __construct($name, $title = '') {
		parent::__construct($name, $title);
	
		if ($this->getModule()->getParam('delete')) {
			$reportToDelete = Rakuun_DB_Containers::getLogSpiesContainer()->selectByPK($this->getModule()->getParam('delete'));
			if ($reportToDelete && $reportToDelete->user->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK()) {
				$reportToDelete->deleted = 1;
				Rakuun_DB_Containers::getLogSpiesContainer()->save($reportToDelete);
			}
		}
	}
	
	public function beforeDisplay() {
		parent::beforeDisplay();
		
		$this->setTemplate(dirname(__FILE__).'/base.tpl');
		$this->addClasses('rakuun_ctn_reports');
		$this->addPanel($table = new GUI_Panel_Table('reports'));
		$units = Rakuun_Intern_Production_Factory::getAllUnits();
		$buildings = Rakuun_Intern_Production_Factory::getAllBuildings();
		$tableHeader = array('Datum', 'Angreifer', 'Ziel');
		foreach ($units as $unit) {
			$tableHeader[] = $unit->getName();
		}
		foreach ($buildings as $building) {
			if ($building->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INVISIBLE_FOR_SPIES))
				continue;
			$tableHeader[] = $building->getName();
		}
		$table->addHeader($tableHeader);
		$table->addFooter($tableHeader);
		$actualUser = Rakuun_User_Manager::getCurrentUser();
		foreach ($this->data as $spy) {
			if (!self::hasPrivilegesToSeeReport($spy))
				continue;
			
			$line = array();
			$date = new GUI_Panel('date'.$spy->getPK());
			$date->addPanel(new GUI_Panel_Text('date'.$spy->getPK(), date(GUI_Panel_Date::FORMAT_DATETIME, $spy->time)));
			$date->addPanel(new GUI_Control_Link('warsim_link'.$spy->getPK(), 'WarSim', App::get()->getInternModule()->getSubmodule('warsim')->getUrl(array('spyreport' => $spy->getPK()))));
			if ($spy->user->getPK() == $actualUser->getPK()) {
				$img = new GUI_Panel_Image('delimg', Router::get()->getStaticRoute('images', 'cancel.gif'));
				$params = array_merge($this->getModule()->getParams(), array('delete' => $spy->getPK()));
				$date->addPanel($link = new GUI_Control_Link('delete_link'.$spy->getPK(), $img->render(), $this->getModule()->getUrl($params)));
				$link->setConfirmationMessage('Diesen Bericht wirklich löschen?');
			}
			$line[] = $date;
			$line[] = new Rakuun_GUI_Control_UserLink('userlink'.$spy->getPK(), $spy->user, $spy->user->getPK());
			$line[] = new Rakuun_GUI_Control_UserLink('spieduserlink'.$spy->getPK(), $spy->spiedUser, $spy->spiedUser);
			foreach ($units as $unit) {
				$line[] = $spy->{Text::underscoreToCamelCase($unit->getInternalName())};
			}
			foreach ($buildings as $building) {
				if ($building->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INVISIBLE_FOR_SPIES))
					continue;
				$line[] = $spy->{Text::underscoreToCamelCase($building->getInternalName())};
			}
			$table->addLine($line);
		}
	}

	public static function hasPrivilegesToSeeReport(DB_Record $report) {
		$actualUser = Rakuun_User_Manager::getCurrentUser();
		if ($report->user->getPK() == $actualUser->getPK())
			return true;
		if ($report->user->alliance !== null && $actualUser->alliance !== null && Rakuun_Intern_Alliance_Security::get()->hasPrivilege($actualUser, Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_REPORTS)) {
			if ($report->user->alliance->getPK() == $actualUser->alliance->getPK())
				return true;
			if ($report->user->alliance->meta !== null && $actualUser->alliance->meta !== null) {
				if ($report->user->alliance->meta->getPK() == $actualUser->alliance->meta->getPK())
					return true;
			}
		}
		return false;
	}
	
	protected function getFilterStrings() {
		$return = array();
		foreach ($this->filter as $filter) {
			if (Text::length($filter['what']) > 0) {
				$relation = Rakuun_Intern_GUI_Panel_Reports_Filter::getRelation($filter['how']);
				$return[] = $filter['filter'].' '.$relation.' '.$filter['what'];
			} else {
				$return[] = '';
			}
		}
		return $return;
	}
	
	public function addFilter(array $filter) {
		$this->filter[] = $filter;
	}
}
?>