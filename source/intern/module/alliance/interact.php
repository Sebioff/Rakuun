<?php
class Rakuun_Intern_Module_Alliance_Interact extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/interact.tpl');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('leavebox', new Rakuun_Intern_GUI_Panel_Alliance_Leave('leave'), 'Allianz verlassen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('depositbox', new Rakuun_Intern_GUI_Panel_Alliance_Account_Deposit('deposit'), 'Auf Allianzkonto einzahlen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('accountbox', new Rakuun_Intern_GUI_Panel_Alliance_Account('account'), 'Allianzkonto'));
	}

	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return (isset($this->getUser()->alliance));
	}
}
?>