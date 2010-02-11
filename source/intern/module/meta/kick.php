<?php

class Rakuun_Intern_Module_Meta_Kick extends Rakuun_Intern_Module_Meta_Navigation {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Allianz kicken - '.$this->getUser()->alliance->meta->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/kick.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('kick', new Rakuun_Intern_GUI_Panel_Meta_Kick('kick'), 'Allianz kicken'));
	}
}

?>