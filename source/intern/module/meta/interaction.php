<?php

class Rakuun_Intern_Module_Meta_Interaction extends Rakuun_Intern_Module_Meta_Common {
	public function init() {
		parent::init();
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/interaction.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('account', new Rakuun_Intern_GUI_Panel_Meta_Account('account'), 'Metakonto'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('deposit', new Rakuun_Intern_GUI_Panel_Meta_Account_Deposit('deposit'), 'Auf Metakonto einzahlen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('leave', new Rakuun_Intern_GUI_Panel_Meta_Leave('leave'), 'Meta verlassen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('allianceaccounts', new Rakuun_Intern_GUI_Panel_Meta_Account_AllianceAccounts('allianceaccounts'), 'Kontostände'));
	}
	
	public function checkPrivileges() {
		return Rakuun_Intern_Alliance_Security::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::GROUP_LEADERS);
	}
}
?>