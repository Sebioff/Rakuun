<?php

/**
 * Panel to edit alliance details
 */
class Rakuun_Intern_GUI_Panel_Alliance_Internbox extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->setTemplate(dirname(__FILE__).'/internbox.tpl');
		$this->addPanel(new GUI_Panel_Text('text', Rakuun_Text::formatPlayerText($user->alliance->intern, false)), 'Interne Informationen');
		$this->addPanel(new GUI_Control_Link('edit', "bearbeiten", App::get()->getInternModule()->getSubmoduleByName('alliance')->getSubmoduleByName('edit')->getUrl()));
	}
}

?>