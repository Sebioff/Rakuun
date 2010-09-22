<?php

class Rakuun_Intern_Module_Meta_Polls extends Rakuun_Intern_Module_Meta_Common {
	public function init() {
		parent::init();

		$this->setPageTitle('Umfragen - '.$this->getUser()->alliance->meta->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/polls.tpl');
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('pollbox', new Rakuun_Intern_GUI_Panel_Polls_AddPoll('poll', Rakuun_Intern_GUI_Panel_Polls::POLL_META), 'Umfrage hinzufügen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('pollsbox', new Rakuun_Intern_GUI_Panel_Polls('polls', Rakuun_Intern_GUI_Panel_Polls::POLL_META), 'Umfragen'));
	}
}

?>