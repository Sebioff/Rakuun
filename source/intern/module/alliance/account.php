<?php

class Rakuun_Intern_Module_Alliance_Account extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();

		$alliance = $this->getUser()->alliance;
		$this->setPageTitle('Allianzkasse - ['.$alliance->tag.'] '.$alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/account.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('account', new Rakuun_Intern_GUI_Panel_Alliance_Account('overview'), 'Allianzkasse'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('payout', new Rakuun_Intern_GUI_Panel_Alliance_Account_Payout('payout'), 'Vom Allianzkonto auszahlen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('logview', new Rakuun_Intern_GUI_Panel_Alliance_Account_LogView('logview'), 'Kontobewegungen einsehen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('useraccounts', new Rakuun_Intern_GUI_Panel_Alliance_Account_UserAccounts('useraccounts'), 'Kontostände'));
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_RESSOURCES);
	}
}

?>