<?php

class Rakuun_Intern_GUI_Panel_Board_Overview extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/overview.tpl');
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$options = array();
		$options['conditions'][] = array('user_name = ?', $user->nameUncolored);
		$options['conditions'][] = array('round_number = ?', RAKUUN_ROUND_NAME);
		$globalBoards = $this->getBoards(
			Rakuun_DB_Containers::getBoardsGlobalLastVisitedContainer()->getFilteredContainer($options),
			Rakuun_DB_Containers::getBoardsGlobalContainer()
		);
		$this->addPanel(new Rakuun_GUI_Panel_Box('globalbox', new Rakuun_Intern_GUI_Panel_Board_List('global', Rakuun_Intern_GUI_Panel_Board_Global::getConfig(), $globalBoards), 'Allgemeines Forum'));
		$options = array();
		$options['conditions'][] = array('user = ?', $user);
		if ($user->alliance) {
			$allianceBoards = $this->getBoards(
				Rakuun_DB_Containers::getBoardsAllianceLastVisitedContainer()->getFilteredContainer($options),
				Rakuun_DB_Containers::getBoardsAllianceContainer()
			);
			$this->addPanel(new Rakuun_GUI_Panel_Box('alliancebox', new Rakuun_Intern_GUI_Panel_Board_List('alliance', Rakuun_Intern_GUI_Panel_Board_Alliance::getConfig(), $allianceBoards), 'Allianzforum'));
			if ($user->alliance->meta) {
				$metaBoards = $this->getBoards(
					Rakuun_DB_Containers::getBoardsMetaLastVisitedContainer()->getFilteredContainer($options),
					Rakuun_DB_Containers::getBoardsMetaContainer()
				);
				$this->addPanel(new Rakuun_GUI_Panel_Box('metabox', new Rakuun_Intern_GUI_Panel_Board_List('meta', Rakuun_Intern_GUI_Panel_Board_Meta::getConfig(), $metaBoards), 'Metaforum'));
			}
		}
		if (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_BACKENDACCESS)) {
			$adminBoards = $this->getBoards(
				Rakuun_DB_Containers::getBoardsAdminLastVisitedContainer()->getFilteredContainer($options),
				Rakuun_DB_Containers::getBoardsAdminContainer()
			);
			$this->addPanel(new Rakuun_GUI_Panel_Box('adminbox', new Rakuun_Intern_GUI_Panel_Board_List('admin', Rakuun_Intern_GUI_Panel_Board_Admin::getConfig(), $adminBoards), 'Adminforum'));
		}
	}
	
	private function getBoards(DB_Container $visitedContainer, DB_Container $boardsContainer) {
		$_visited = $visitedContainer->select();
		$visited = array();
		foreach ($_visited as $v) {
			$visited[$v->board->getPK()] = $v;
		}
		$_boards = $boardsContainer->select();
		$boards = array();
		foreach ($_boards as $board) {
			if (isset($visited[$board->getPK()]) && $visited[$board->getPK()]->date < $board->date)
				$boards[] = $board;
			if (!isset($visited[$board->getPK()]))
				$boards[] = $board;
		}
		return $boards;
	}
}
?>