<?php

class Rakuun_Index_Module_News extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('News');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/news.tpl');
		$this->setMetaTag('description', 'Neuigkeiten über das kostenlose SciFi-Browsergames Rakuun.');
		$this->setMetaTag('keywords', 'browsergame, scifi, news');
		
		$this->contentPanel->addPanel($newsBox = new Rakuun_Index_Panel_News_Overview('news', 'News'));
		$newsBox->addClasses('rakuun_box_news');
		
		if ($logoutReason = $this->getParam('logout-reason')) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box_Note('logout_reason', $logoutReasonText = new GUI_Panel_Text('logout_reason', '', 'Ausgeloggt'), 'Ausgeloggt'));
			switch ($logoutReason) {
				case 'noactivity':
					$logoutReasonText->setText('Du wurdest sicherheitshalber automatisch ausgeloggt, da du für mindestens '.Rakuun_Date::formatCountDown(Rakuun_Intern_Module::TIMEOUT_NOACTIVITY).' keine Aktionen durchgeführt hast.');
				break;
			}
		}
	}
}

?>