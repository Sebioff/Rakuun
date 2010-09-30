<?php

class Rakuun_Intern_GUI_Panel_Board_Overview_Alliance extends Rakuun_Intern_GUI_Panel_Board_Overview_Base {
	public function init() {
		parent::init();
		
		$visitedOptions = array();
		$visitedOptions['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$boardsOptions = array();
		$boardsOptions['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		$allianceBoards = $this->getBoards(
			Rakuun_DB_Containers::getBoardsAllianceLastVisitedContainer()->getFilteredContainer($visitedOptions),
			Rakuun_DB_Containers::getBoardsAllianceContainer()->getFilteredContainer($boardsOptions)
		);
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_List('list', Rakuun_Intern_GUI_Panel_Board_Alliance::getConfig(), $allianceBoards));
	}
}
?>