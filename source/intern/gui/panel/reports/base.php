<?php

abstract class Rakuun_Intern_GUI_Panel_Reports_Base extends GUI_Panel {
	protected $data = array();
	protected $filter = array();
	private $table;
	
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
	
	public function beforeInit() {
		parent::beforeInit();
		
		$this->addPanel($this->table = new GUI_Panel_Table('reports'));
		$this->table->setFoldEvery(10, 'Ältere Berichte', 'addMouseOver();');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->setTemplate(dirname(__FILE__).'/base.tpl');
		$units = Rakuun_Intern_Production_Factory::getAllUnits();
		$buildings = Rakuun_Intern_Production_Factory::getAllBuildings();

		$this->table->addHeader(array('Datum', 'Angreifer', 'Ziel', 'Att', 'Deff', '&Delta; Att', '&Delta; Deff'));

		$actualUser = Rakuun_User_Manager::getCurrentUser();
		$data = array();
		$lastAtt = 0;
		$lastDeff = 0;
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
			$atter = new GUI_Panel('atter'.$spy->getPK());
			if ($spy->user->alliance) {
				$atter->addPanel($link = new Rakuun_GUI_Control_AllianceLink('atteralliancelink'.$spy->getPK(), $spy->user->alliance));
				$link->setDisplay(Rakuun_GUI_Control_AllianceLink::DISPLAY_TAG_ONLY);
			}
			$atter->addPanel(new Rakuun_GUI_Control_UserLink('userlink'.$spy->getPK(), $spy->user, $spy->user->getPK()));
			$line[] = $atter;
			$target = new GUI_Panel('target'.$spy->getPK());
			if ($spy->spiedUser->alliance) {
				$target->addPanel($link = new Rakuun_GUI_Control_AllianceLink('targetalliancelink'.$spy->getPK(), $spy->spiedUser->alliance));
				$link->setDisplay(Rakuun_GUI_Control_AllianceLink::DISPLAY_TAG_ONLY);
			}
			$target->addPanel(new Rakuun_GUI_Control_UserLink('spieduserlink'.$spy->getPK(), $spy->spiedUser, $spy->spiedUser));
			$line[] = $target;
			$att = 0;
			$deff = 0;
			foreach ($units as $unit) {
				$att += $unit->getAttackValue($spy->{Text::underscoreToCamelCase($unit->getInternalName())});
				$deff += $unit->getDefenseValue($spy->{Text::underscoreToCamelCase($unit->getInternalName())});
			}
			$line[] = $att;
			$line[] = $deff;
			$deltaAtt = $att - $lastAtt;
			$deltaDeff = $deff - $lastDeff; 
			$line[] = $lastAtt > 0 ? $deltaAtt : $att;
			$line[] = $lastDeff > 0 ? $deltaDeff : $deff;
			$lastAtt = $att;
			$lastDeff = $deff;
			$data[] = $line;
		}
		foreach (array_reverse($data) as $line) {
			$this->table->addLine($line);
		}
		$this->addJS('
			var reportCache = new Array();
			function addMouseOver() {
				$("#'.$this->table->getAjaxID().'").children("tbody").children("tr").not("#'.$this->table->getAjaxID().'-fold").mouseover(function() {
					spyId = /spyreport_(\d+)\"/.exec($(this).children().html())[1];
					if (reportCache[spyId] == undefined) {
						$.core.ajaxRequest(
							"'.$this->getAjaxID().'",
							"ajaxLoadReport",
							{ id: spyId },
							function(data) {
								reportCache[spyId] = data;
								$("#details").html(data);
							}
						);
					} else {
						$("#details").html(reportCache[spyId]);
					}
				});
			}
			addMouseOver();
		');
	}
	
	public function ajaxLoadReport() {
		$report = Rakuun_DB_Containers::getLogSpiesContainer()->selectByPK((int)$_POST['id']);
		if (!$report || !self::hasPrivilegesToSeeReport($report))
			return 'Keine Berechtigung für diesen Report';
		
		$userLink = new Rakuun_GUI_Control_UserLink('userlink', $report->spiedUser);
		$str = 'Ziel: '.$userLink->render().'<br />';
		$str .= date(GUI_Panel_Date::FORMAT_DATETIME, $report->time).'<br />';
		foreach (Rakuun_Intern_Production_Factory::getAllBuildings($report) as $building) {
			$str .= $building->getName().': '.$report->{Text::underscoreToCamelCase($building->getInternalName())}.'<br />';
		}
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($report) as $unit) {
			$str .= $unit->getName().': '.$report->{Text::underscoreToCamelCase($unit->getInternalName())}.'<br />';
		}
		return $str;
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