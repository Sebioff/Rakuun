<?php

class Rakuun_Intern_Module_Alliance_Profile_None extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Allianz gründen');
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Alliance_Profile_None('profile'));
	}
}
?>