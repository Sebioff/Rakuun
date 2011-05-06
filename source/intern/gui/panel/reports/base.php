<?php

abstract class Rakuun_Intern_GUI_Panel_Reports_Base extends GUI_Panel {
	protected $data = array();
	protected $filter = array();
	private $table;
	private $detailBox = null;
	
	const REPORTS_PER_PAGE = 20;
	const MAX_REPORTS_TO_LOAD = 300;
	
	public function __construct($name, Rakuun_GUI_Panel_Box $detailBox, $title = '') {
		parent::__construct($name, $title);
		
		$this->detailBox = $detailBox;
	
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
		$this->table->setFoldEvery(self::REPORTS_PER_PAGE, 'Ältere Berichte', 'addJsReports()');
		$this->addJs('function addJsReports() {
			$.core.ajaxRequest(
				"'.$this->getAjaxID().'",
				"ajaxAddJsReports",
				{ after: foldedAfter[\''.$this->table->getName().'\'] },
				function(data) {
					eval(data);
				}
			);
		}');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->setTemplate(dirname(__FILE__).'/base.tpl');
		
		$this->table->addHeader(array('Datum', 'Angreifer', 'Ziel', 'Att', 'Deff', '&Delta; Att', '&Delta; Deff'));
		$this->table->addTableCssClass('align_right', 3);
		$this->table->addTableCssClass('align_right', 4);
		$this->table->addTableCssClass('align_right', 5);
		$this->table->addTableCssClass('align_right', 6);

		$actualUser = Rakuun_User_Manager::getCurrentUser();
		$jsReports = 'var reportCache = new Array();';
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
			if ($spy->spiedUser && $spy->spiedUser->alliance) {
				$target->addPanel($link = new Rakuun_GUI_Control_AllianceLink('targetalliancelink'.$spy->getPK(), $spy->spiedUser->alliance));
				$link->setDisplay(Rakuun_GUI_Control_AllianceLink::DISPLAY_TAG_ONLY);
			}
			$target->addPanel(new Rakuun_GUI_Control_UserLink('spieduserlink'.$spy->getPK(), $spy->spiedUser, $spy->spiedUser));
			$line[] = $target;
			$att = 0;
			$deff = 0;
			$units = Rakuun_Intern_Production_Factory::getAllUnits($spy->user);
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
			if ($this->table->getLineCount() < self::REPORTS_PER_PAGE)
				$jsReports .= $this->formatReportForJS($spy, $previousReport);
			
			$this->table->addLine($line);
		}
		$this->getModule()->addJsRouteReference('core_js', 'base64.js');
		$jsReports .= '$("#'.$this->table->getAjaxID().' tbody tr:not(#'.$this->table->getAjaxID().'-fold)").live("mouseover", function() {
			$("#'.$this->detailBox->getID().' .content_inner").html(base64.decode(reportCache[/spyreport_(\d+)\"/.exec($(this).children().html())[1]]));
		})';
		$this->addJS($jsReports);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Record
	 */
	public static function getNewestReportForUser(Rakuun_DB_User $user, Rakuun_DB_User $currentUser = null) {
		if (!$currentUser)
			$currentUser = Rakuun_User_Manager::getCurrentUser();
		
		$previousReport = null;
		$options = array();
		$options['conditions'][] = array('spied_user = ?', $user);
		$options['conditions'][] = array('deleted = ?', 0);
		$options['order'] = 'time DESC';
		foreach (Rakuun_DB_Containers::getLogSpiesContainer()->select($options) as $oldReport) {
			if (!Rakuun_Intern_GUI_Panel_Reports_Base::hasPrivilegesToSeeReport($oldReport, $currentUser))
				continue;
				
			$previousReport = $oldReport;
			break;
		}
		
		return $previousReport;
	}
	
	/**
	 * @return DB_Record
	 */
	private function getPreviousReportOf(DB_Record $report) {
		$previousReport = null;
		$options = array();
		$options['conditions'][] = array('spied_user = ?', $report->spiedUser);
		$options['conditions'][] = array('deleted = ?', 0);
		$options['conditions'][] = array('id < ?', $report->getPK());
		$options['order'] = 'time DESC';
		foreach (Rakuun_DB_Containers::getLogSpiesContainer()->select($options) as $oldReport) {
			if (!self::hasPrivilegesToSeeReport($oldReport))
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
	
	// CUSTOM FUNCTIONS --------------------------------------------------------
	private function formatReportForJS($report, $previousReport = null) {
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
		
		return 'reportCache['.$report->getPK().'] = \''.base64_encode($templateEngine->render(dirname(__FILE__).'/report.tpl')).'\';';
	}

	public static function hasPrivilegesToSeeReport(DB_Record $report, Rakuun_DB_User $currentUser = null) {
		if (!$currentUser)
			$currentUser = Rakuun_User_Manager::getCurrentUser();
		
		if ($report->user->getPK() == $currentUser->getPK())
			return true;
		if ($report->user->alliance !== null && $currentUser->alliance !== null && Rakuun_Intern_Alliance_Security::get()->hasPrivilege($currentUser, Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_REPORTS)) {
			if ($report->user->alliance->getPK() == $currentUser->alliance->getPK())
				return true;
			if ($report->user->alliance->meta !== null && $currentUser->alliance->meta !== null) {
				if ($report->user->alliance->meta->getPK() == $currentUser->alliance->meta->getPK())
					return true;
			}
		}
		return false;
	}
	
	// AJAX-CALLBACKS ----------------------------------------------------------
	public function ajaxAddJsReports() {
		$str = '';
		foreach (array_slice($this->data, $_POST['after'] - self::REPORTS_PER_PAGE, self::REPORTS_PER_PAGE) as $report) {
			$str .= $this->formatReportForJS($report, $this->getPreviousReportOf($report));
		}
		return $str;
	}
}

?>