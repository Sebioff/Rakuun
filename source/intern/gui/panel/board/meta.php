<?php

class Rakuun_Intern_GUI_Panel_Board_Meta extends Rakuun_Intern_GUI_Panel_Board {
	public function __construct($name, $title = '') {
		$this->config = self::getConfig();
		
		parent::__construct($name, $title);
	}
	
	public static function getConfig() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$config = new Board_Config();
		$options = array();
		$options['conditions'][] = array('meta = ?', $user->alliance->meta);
		$config->setBoardsContainer(Rakuun_DB_Containers::getBoardsMetaContainer()->getFilteredContainer($options));
		$board = new DB_Record();
		$board->meta = $user->alliance->meta;
		$config->setBoardRecord($board);
		$config->setPostingsContainer(Rakuun_DB_Containers::getBoardsMetaPostingsContainer());
		$posting = new DB_Record();
		$posting->user = $user;
		$config->setPostingRecord($posting);
		$config->setVisitedContainer(Rakuun_DB_Containers::getBoardsMetaLastVisitedContainer());
		$config->setBoardModule(App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('meta'));
		$config->setUserIsMod(Rakuun_Intern_Alliance_Security::get()->hasPrivilege($user, Rakuun_Intern_Alliance_Security::PRIVILEGE_MODERATION));
		
		return $config;
	}
}
?>