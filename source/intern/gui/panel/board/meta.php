<?php

class Rakuun_Intern_GUI_Panel_Board_Meta extends Rakuun_Intern_GUI_Panel_Board {
	public function __construct($name, $title = '') {
		$this->config = self::getConfig();
		
		parent::__construct($name, $title);
	}
	
	public static function getNewPostingsCount(DB_Container $null = null, DB_Container $anothernull = null) {
		return parent::getNewPostingsCount(
			Rakuun_DB_Containers::getBoardsMetaContainer()->getFilteredContainer(self::getMetaFilter()),
			Rakuun_DB_Containers::getBoardsMetaLastVisitedContainer()
		);
	}
	
	private static function getMetaFilter() {
		$options = array();
		$options['conditions'][] = array('meta = ?', Rakuun_User_Manager::getCurrentUser()->alliance->meta);
		return $options; 
	}
	
	public static function getConfig() {
		$config = new Board_Config();
		$config->setBoardsContainer(Rakuun_DB_Containers::getBoardsMetaContainer()->getFilteredContainer(self::getMetaFilter()));
		$board = new DB_Record();
		$board->meta = Rakuun_User_Manager::getCurrentUser()->alliance->meta;
		$config->setBoardRecord($board);
		$config->setPostingsContainer(Rakuun_DB_Containers::getBoardsMetaPostingsContainer());
		$posting = new DB_Record();
		$posting->user = Rakuun_User_Manager::getCurrentUser();
		$config->setPostingRecord($posting);
		$config->setVisitedContainer(Rakuun_DB_Containers::getBoardsMetaLastVisitedContainer());
		$config->setBoardModule(App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('meta'));
		return $config;
	}
}
?>