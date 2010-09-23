<?php

class Rakuun_Intern_GUI_Panel_Board_Overview_Alliance extends Rakuun_Intern_GUI_Panel_Board_Overview_Base {
	public function init() {
		parent::init();
		
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$allianceBoards = $this->getBoards(
			Rakuun_DB_Containers::getBoardsAllianceLastVisitedContainer()->getFilteredContainer($options),
			Rakuun_DB_Containers::getBoardsAllianceContainer()
		);
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_List('list', Rakuun_Intern_GUI_Panel_Board_Alliance::getConfig(), $allianceBoards));
	}
}
?>