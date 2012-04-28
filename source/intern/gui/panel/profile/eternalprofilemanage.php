<?php

class Rakuun_Intern_GUI_Panel_Profile_EternalProfileManage extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/eternalprofilemanage.tpl');
		
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Profile_EternalProfileCreate('create'));
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Profile_EternalProfileConnect('connect'));
	}
}

?>