<?php

class Rakuun_Index_Module_Login extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Login');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/login.tpl');
		$this->setMetaTag('description', 'Steige in die Welt des kostenlosen SciFi-Browsergames Rakuun ein und kämpfe um die Herrschaft über den Planeten und den Bau eines gigantischen Raumschiffes!');
		$this->setMetaTag('keywords', 'browsergame, scifi, login');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('login', new Rakuun_Index_Panel_Login('content'), 'Jetzt einloggen!'));
		$this->contentPanel->addPanel(new Rakuun_Index_Panel_News_Overview('news', 'News'));
		
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