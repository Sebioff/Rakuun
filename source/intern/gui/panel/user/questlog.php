<?php

class Rakuun_Intern_GUI_Panel_User_QuestLog extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/questlog.tpl');
	}
}
?>