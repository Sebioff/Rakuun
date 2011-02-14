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
		$this->table->addTableCssClass('align_right', 3);
		$this->table->addTableCssClass('align_right', 4);
		$this->table->addTableCssClass('align_right', 5);
		$this->table->addTableCssClass('align_right', 6);

		$actualUser = Rakuun_User_Manager::getCurrentUser();
		$data = array();
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
			
			$previousReport = $this->getPreviousReportOf($spy);
			$lastAtt = 0;
			$lastDeff = 0;
			if ($previousReport) {
				foreach ($units as $unit) {
					$lastAtt += $unit->getAttackValue($previousReport->{Text::underscoreToCamelCase($unit->getInternalName())});
					$lastDeff += $unit->getDefenseValue($previousReport->{Text::underscoreToCamelCase($unit->getInternalName())});
				}
			}
			
			$line[] = $att;
			$line[] = $deff;
			$deltaAtt = $lastAtt > 0 ? $att - $lastAtt : $att;
			$deltaDeff = $lastDeff > 0 ? $deff - $lastDeff : $deff;
			$line[] = new Rakuun_Intern_GUI_Panel_Reports_DeltaIcon('delta_att'.$spy->getPK(), $deltaAtt);
			$line[] = new Rakuun_Intern_GUI_Panel_Reports_DeltaIcon('delta_deff'.$spy->getPK(), $deltaDeff);
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
						$("#'.$this->getParent()->getParent()->getID().'").addClass("ajax_loading");
						$.core.ajaxRequest(
							"'.$this->getAjaxID().'",
							"ajaxLoadReport",
							{ id: spyId },
							function(data) {
								reportCache[spyId] = data;
								$("#'.$this->getParent()->getParent()->getID().'").removeClass("ajax_loading");
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
		
		$previousReport = $this->getPreviousReportOf($report);
		
		if (!$report || !self::hasPrivilegesToSeeReport($report))
			return 'Keine Berechtigung für diesen Report';
		
		$reportTable = new GUI_Panel_Table('report_table');
		$reportTable->addTableCssClass('align_right', 1);
		$reportTable->addTableCssClass('align_right', 2);
		
		foreach (Rakuun_Intern_Production_Factory::getAllBuildings($report) as $building) {
			$delta = ($previousReport) ? $building->getLevel() - $previousReport->{Text::underscoreToCamelCase($building->getInternalName())} : $building->getLevel();
			$reportTable->addLine(array($building->getName(), GUI_Panel_Number::formatNumber($building->getLevel()), new Rakuun_Intern_GUI_Panel_Reports_DeltaIcon('delta'.$building->getInternalName(), $delta)));
		}
		
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($report) as $unit) {
			$delta = ($previousReport) ? $unit->getAmount() - $previousReport->{Text::underscoreToCamelCase($unit->getInternalName())} : $unit->getAmount();
			$reportTable->addLine(array($unit->getName(), GUI_Panel_Number::formatNumber($unit->getAmount()), new Rakuun_Intern_GUI_Panel_Reports_DeltaIcon('delta'.$unit->getInternalName(), $delta)));
		}
		
		$templateEngine = new GUI_TemplateEngine();
		$templateEngine->report = $report;
		$templateEngine->userLink = new Rakuun_GUI_Control_UserLink('userlink', $report->spiedUser);
		$templateEngine->reportTable = $reportTable;
		
		return $templateEngine->render(dirname(__FILE__).'/report.tpl');
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
	
	private function getPreviousReportOf(DB_Record $report) {
		$previousReport = null;
		$options = array();
		$options['conditions'][] = array('spied_user = ?', $report->spiedUser);
		$options['conditions'][] = array('deleted = ?', 0);
		$options['conditions'][] = array('id < ?', $report->getPK());
		$options['order'] = 'time DESC';
		foreach (Rakuun_DB_Containers::getLogSpiesContainer()->select($options) as $oldReport) {
			if (!$this->hasPrivilegesToSeeReport($oldReport))
				continue;
				
			$previousReport = $oldReport;
			break;
		}
		
		return $previousReport;
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