<?php

class Rakuun_Intern_GUI_Panel_Board_Overview_Meta extends Rakuun_Intern_GUI_Panel_Board_Overview_Base {
	public function init() {
		parent::init();
		
		$visitedOptions = array();
		$visitedOptions['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$boardsOptions = array();
		$boardsOptions['conditions'][] = array('meta = ?', Rakuun_User_Manager::getCurrentUser()->alliance->meta);
		$metaBoards = $this->getBoards(
			Rakuun_DB_Containers::getBoardsMetaLastVisitedContainer()->getFilteredContainer($visitedOptions),
			Rakuun_DB_Containers::getBoardsMetaContainer()->getFilteredContainer($boardsOptions)
		);
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_List('list', Rakuun_Intern_GUI_Panel_Board_Meta::getConfig(), $metaBoards));
		$this->addPanel(new GUI_Control_Link('boardlink', 'Zum Forum', App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('meta')->getUrl()));
	}
}
?>