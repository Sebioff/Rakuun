<?php

class Rakuun_Intern_Module_Alliance_Polls extends Rakuun_Intern_Module implements Scriptlet_Privileged {
	public function init() {
		parent::init();

		$alliance = $this->getUser()->alliance;
		$this->setPageTitle('Umfragen - ['.$alliance->tag.'] '.$alliance->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/polls.tpl');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('pollbox', new Rakuun_Intern_GUI_Panel_Polls_AddPoll('poll', Rakuun_Intern_GUI_Panel_Polls::POLL_ALLIANCE), 'Umfrage hinzufügen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('pollsbox', new Rakuun_Intern_GUI_Panel_Polls('polls', Rakuun_Intern_GUI_Panel_Polls::POLL_ALLIANCE), 'Umfragen'));
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function checkPrivileges() {
		return (isset($this->getUser()->alliance));
	}
}

?>