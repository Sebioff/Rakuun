<?php

class Rakuun_Intern_Module_Meta_Applications extends Rakuun_Intern_Module_Meta_Common {
	public function init() {
		parent::init();

		$this->setPageTitle('Bewerbungen - '.$this->getUser()->alliance->meta->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/applications.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('applications', new Rakuun_Intern_GUI_Panel_Meta_Applications('applications'), 'Bewerbungen'));
	}
}

?>