<?php

class Rakuun_Intern_Module_Reports extends Rakuun_Intern_Module {
	const SHOW_OWN = 'own';
	const SHOW_ALLIANCE = 'alliance';
	const SHOW_META = 'meta';
	
	public function init() {
		parent::init();
		
		$this->setPageTitle('Spionagecenter');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/reports.tpl');
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->contentPanel->addPanel($box = new Rakuun_GUI_Panel_Box('reportsbox', null, 'Berichte'));
		switch ($this->getParam('show')) {
			case self::SHOW_ALLIANCE:
				$box->getContentPanel()->addPanel(new Rakuun_Intern_GUI_Panel_Reports_ByAlliance('reports'));
			break;
			case self::SHOW_META:
				$box->getContentPanel()->addPanel(new Rakuun_Intern_GUI_Panel_Reports_ByMeta('reports'));
			break;
			case self::SHOW_OWN:
			default:
				$box->getContentPanel()->addPanel(new Rakuun_Intern_GUI_Panel_Reports_Own('reports'));
			break;
		}
		$this->contentPanel->addPanel($menubox = new Rakuun_GUI_Panel_Box('menubox', null, 'Quelle'));
		$menubox->getContentPanel()->addPanel(new GUI_Control_Link('ownlink', 'Eigene Berichte', $this->getUrl()));
		if ($user->alliance)
			$menubox->getContentPanel()->addPanel(new GUI_Control_Link('alliancelink', '| Allianzberichte', $this->getUrl(array('show' => self::SHOW_ALLIANCE))));
		if ($user->alliance && $user->alliance->meta)
			$menubox->getContentPanel()->addPanel(new GUI_Control_Link('metalink', '| Metaberichte', $this->getURL(array('show' => self::SHOW_META))));
		$this->contentPanel->addPanel($filterbox = new Rakuun_GUI_Panel_Box('filterbox', null, 'Filter'));
		$filterbox->getContentPanel()->addPanel(new Rakuun_Intern_GUI_Panel_Reports_Filter('filter'));
	}
}
?>