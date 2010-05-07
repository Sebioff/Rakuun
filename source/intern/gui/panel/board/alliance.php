<?php

class Rakuun_Intern_GUI_Panel_Board_Alliance extends Rakuun_Intern_GUI_Panel_Board {
	public function __construct($name, $title = '') {
		$this->config = self::getConfig();
		
		parent::__construct($name, $title);
	}
	
	public static function getConfig() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$config = new Board_Config();
		$options = array();
		$options['conditions'][] = array('alliance = ?', $user->alliance);
		$config->setBoardsContainer(Rakuun_DB_Containers::getBoardsAllianceContainer()->getFilteredContainer($options));
		$board = new DB_Record();
		$board->alliance = $user->alliance;
		$config->setBoardRecord($board);
		$config->setPostingsContainer(Rakuun_DB_Containers::getBoardsAlliancePostingsContainer());
		$posting = new DB_Record();
		$posting->user = $user;
		$config->setPostingRecord($posting);
		$config->setVisitedContainer(Rakuun_DB_Containers::getBoardsAllianceLastVisitedContainer());
		$config->setBoardModule(App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('alliance'));
		$config->setUserIsMod(Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_MODERATION));
		
		return $config;
	}
}
?>