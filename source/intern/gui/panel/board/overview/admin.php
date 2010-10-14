<?php

class Rakuun_Intern_GUI_Panel_Board_Overview_Admin extends Rakuun_Intern_GUI_Panel_Board_Overview_Base {
	public function init() {
		parent::init();
		
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$adminBoards = $this->getBoards(
			Rakuun_DB_Containers::getBoardsAdminLastVisitedContainer()->getFilteredContainer($options),
			Rakuun_DB_Containers::getBoardsAdminContainer()
		);
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_List('list', Rakuun_Intern_GUI_Panel_Board_Admin::getConfig(), $adminBoards));
		$this->addPanel(new GUI_Control_Link('boardlink', 'Zum Forum', App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('admin')->getUrl()));
	}
}

?>