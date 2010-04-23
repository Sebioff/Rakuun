<?php

class Rakuun_Intern_GUI_Panel_Board_Global extends Rakuun_Intern_GUI_Panel_Board {
	public function __construct($name, $title = '') {
		$this->config = self::getConfig();
		parent::__construct($name, $title);
	}
	
	public static function getNewPostingsCount(DB_Container $null = null, DB_Container $anothernull = null) {
		return parent::getNewPostingsCount(
			Rakuun_DB_Containers::getBoardsGlobalContainer(),
			Rakuun_DB_Containers::getBoardsGlobalLastVisitedContainer()
		);
	}
	
	public static function getConfig() {
		$config = new Board_Config();
		$config->setBoardsContainer(Rakuun_DB_Containers::getBoardsGlobalContainer());
		$config->setBoardRecord(new DB_Record());
		$config->setPostingsContainer(Rakuun_DB_Containers::getBoardsGlobalPostingsContainer());
		$posting = new DB_Record();
		$posting->userName = Rakuun_User_Manager::getCurrentUser()->nameUncolored;
		$posting->roundNumber = RAKUUN_ROUND_NAME;
		$config->setPostingRecord($posting);
		$config->setVisitedContainer(Rakuun_DB_Containers::getBoardsGlobalLastVisitedContainer());
		$config->setIsGlobal(true);
		$config->setBoardModule(App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('global'));
		
		return $config;
	}
}

?>