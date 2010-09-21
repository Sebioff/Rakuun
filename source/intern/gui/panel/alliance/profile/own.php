<?php

class Rakuun_Intern_GUI_Panel_Alliance_Profile_Own extends GUI_Panel {
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->params->alliance = $user->alliance;
		
		$this->getModule()->setPageTitle('Allianz - ['.$user->alliance->tag.'] '.$user->alliance->name);
		$this->setTemplate(dirname(__FILE__).'/own.tpl');
		
		$this->addPanel(new Rakuun_GUI_Panel_Box('leave', new Rakuun_Intern_GUI_Panel_Alliance_Leave('leave'), 'Allianz verlassen'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('deposit', new Rakuun_Intern_GUI_Panel_Alliance_Account_Deposit('deposit'), 'Auf Allianzkonto einzahlen'));
		$this->addPanel(new Rakuun_GUI_Panel_Box('account', new Rakuun_Intern_GUI_Panel_Alliance_Account('account'), 'Allianzkonto'));
		if (Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_ACTIVITY))
			$this->addPanel(new Rakuun_GUI_Panel_Box('activity', new Rakuun_Intern_GUI_Panel_Alliance_Activity('activityoverview'), 'Letzte Aktivitäten'));
		if ($user->alliance->picture)
			$this->addPanel(new Rakuun_GUI_Panel_Box('picture', new GUI_Panel_UploadedFile('alliancepicture', $user->alliance->picture, 'Allianzbild der Allianz '.$user->alliance->name), 'Allianzbild'));
	}
}
?>