<?php

class Rakuun_Intern_Module_Alliance_Statistics extends Rakuun_Intern_Module_Alliance_Navigation implements Scriptlet_Privileged {
	public function init() {
		parent::init();

		$alliance = $this->getUser()->alliance;
		$this->setPageTitle('Statistiken - ['.$alliance->tag.'] '.$alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/statistics.tpl');
		
		$user = Rakuun_User_Manager::getCurrentUser();
		if (Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_STATISTICS)) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('ressources', new Rakuun_Intern_GUI_Panel_Alliance_Statistic_Ressources('ressources'), 'Rohstoffübersicht'));
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('army', new Rakuun_Intern_GUI_Panel_Alliance_Statistic_Army('army'), 'Armeeübersicht'));
		}
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return Rakuun_Intern_Alliance_Security::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_Intern_Alliance_Security::PRIVILEGE_SEE_STATISTICS);
	}
}

?>