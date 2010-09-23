<?php

class Rakuun_Intern_GUI_Panel_Board_Overview_Meta extends Rakuun_Intern_GUI_Panel_Board_Overview_Base {
	public function init() {
		parent::init();
		
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$metaBoards = $this->getBoards(
			Rakuun_DB_Containers::getBoardsMetaLastVisitedContainer()->getFilteredContainer($options),
			Rakuun_DB_Containers::getBoardsMetaContainer()
		);
		$this->addPanel(new Rakuun_Intern_GUI_Panel_Board_List('list', Rakuun_Intern_GUI_Panel_Board_Meta::getConfig(), $metaBoards));
	}
}
?>