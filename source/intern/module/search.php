<?php

/**
 * Page to Search on registered Users
 *
 * @author dr.dent
 *
 */
class Rakuun_Intern_Module_Search extends Rakuun_Intern_Module {
	
	public function init() {
		parent::init();
		
		$this->setPageTitle('Suchen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/search.tpl');

		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('user', new Rakuun_Intern_GUI_Panel_User_Search('suchen'), 'User suchen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('alliance', new Rakuun_Intern_GUI_Panel_Alliance_Search('search'), 'Allianz suchen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('onlineuser', new Rakuun_Intern_GUI_Panel_User_Online('onlineuser'), 'User, die gerade online sind:'));
	}
}

?>