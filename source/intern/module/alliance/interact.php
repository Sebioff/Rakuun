<?php
class Rakuun_Intern_Module_Alliance_Interact extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/interact.tpl');
		if (Rakuun_Intern_Mode::getCurrentMode()->allowLeaveAlliances()) {
			$this->contentPanel->addPanel($leaveBox = new Rakuun_GUI_Panel_Box('leavebox', new Rakuun_Intern_GUI_Panel_Alliance_Leave('leave'), 'Allianz verlassen'));
			$leaveBox->addClasses('rakuun_box_alliance_leave');
		}
		$this->contentPanel->addPanel($depositBox = new Rakuun_GUI_Panel_Box('depositbox', new Rakuun_Intern_GUI_Panel_Alliance_Account_Deposit('deposit'), 'Auf Allianzkonto einzahlen'));
		$depositBox->addClasses('rakuun_box_alliance_deposit');
		$this->contentPanel->addPanel($accountBox = new Rakuun_GUI_Panel_Box('accountbox', new Rakuun_Intern_GUI_Panel_Alliance_Account('account'), 'Allianzkonto'));
		$accountBox->addClasses('rakuun_box_alliance_account');
	}

	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return (isset($this->getUser()->alliance));
	}
}
?>