<?php

class Rakuun_Intern_GUI_Panel_Board_Alliance extends Rakuun_Intern_GUI_Panel_Board {
	public function __construct($name, $title = '') {
		$this->config = self::getConfig();
		
		parent::__construct($name, $title);
	}
	
	public static function getNewPostingsCount(DB_Container $null = null, DB_Container $anothernull = null) {
		return parent::getNewPostingsCount(
			Rakuun_DB_Containers::getBoardsAllianceContainer()->getFilteredContainer(self::getAllianceFilter()),
			Rakuun_DB_Containers::getBoardsAllianceLastVisitedContainer()
		);
	}
	
	private static function getAllianceFilter() {
		$options = array();
		$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		return $options; 
	}
	
	public static function getConfig() {
		$config = new Board_Config();
		$config->setBoardsContainer(Rakuun_DB_Containers::getBoardsAllianceContainer()->getFilteredContainer(self::getAllianceFilter()));
		$board = new DB_Record();
		$board->alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		$config->setBoardRecord($board);
		$config->setPostingsContainer(Rakuun_DB_Containers::getBoardsAlliancePostingsContainer());
		$posting = new DB_Record();
		$posting->user = Rakuun_User_Manager::getCurrentUser();
		$config->setPostingRecord($posting);
		$config->setVisitedContainer(Rakuun_DB_Containers::getBoardsAllianceLastVisitedContainer());
		$config->setBoardModule(App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('alliance'));
		return $config;
	}
}
?>