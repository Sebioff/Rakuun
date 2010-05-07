<?php

class Rakuun_Intern_GUI_Panel_Board_Global extends Rakuun_Intern_GUI_Panel_Board {
	public function __construct($name, $title = '') {
		$this->config = self::getConfig();
		
		parent::__construct($name, $title);
	}
	
	public static function getConfig() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$config = new Board_Config();
		$config->setBoardsContainer(Rakuun_DB_Containers::getBoardsGlobalContainer());
		$config->setBoardRecord(new DB_Record());
		$config->setPostingsContainer(Rakuun_DB_Containers::getBoardsGlobalPostingsContainer());
		$posting = new DB_Record();
		$posting->userName = $user->nameUncolored;
		$posting->roundNumber = RAKUUN_ROUND_NAME;
		$config->setPostingRecord($posting);
		$config->setVisitedContainer(Rakuun_DB_Containers::getBoardsGlobalLastVisitedContainer());
		$config->setIsGlobal(true);
		$config->setBoardModule(App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('global'));
		$config->setUserIsMod(Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_MODERATION));
		
		return $config;
	}
}

?>