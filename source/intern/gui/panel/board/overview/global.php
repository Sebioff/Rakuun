<?php

class Rakuun_Intern_GUI_Panel_Board_Overview_Global extends Rakuun_Intern_GUI_Panel_Board_Overview_Base {
	public function init() {
		parent::init();
		
		$options = array();
		$options['conditions'][] = array('user_name = ?', Rakuun_User_Manager::getCurrentUser()->nameUncolored);
		$options['conditions'][] = array('round_number = ?', RAKUUN_ROUND_NAME);
		$globalBoards = $this->getBoards(
			Rakuun_DB_Containers_Persistent::getBoardsGlobalLastVisitedContainer()->getFilteredContainer($options),
			Rakuun_DB_Containers_Persistent::getBoardsGlobalContainer()
		);
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_List('global', Rakuun_Intern_GUI_Panel_Board_Global::getConfig(), $globalBoards));
		$this->addPanel(new GUI_Control_Link('boardlink', 'Zum Forum', App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('global')->getUrl()));
	}
}
?>