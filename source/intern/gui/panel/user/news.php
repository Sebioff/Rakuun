<?php

class Rakuun_Intern_GUI_Panel_User_News extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/news.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();
		
		if (!Rakuun_User_Manager::isSitting()) {
			$options = array();
			$options['conditions'][] = array('user = ?', $user);
			$options['conditions'][] = array('has_been_read = ?', 0);
			if ($unreadMessages = Rakuun_DB_Containers::getMessagesContainer()->count($options)) {
				$url = App::get()->getInternModule()->getSubmodule('messages')->getUrl(array('category' => Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_UNREAD));
				$this->addPanel($unreadMessagesLink = new GUI_Control_Link('unread_messages', 'Du hast '.$unreadMessages.' ungelesene Nachrichten.', $url));
				if ($unreadMessages == 1)
					$unreadMessagesLink->setCaption('Du hast 1 ungelesene Nachricht.');
			}
			
			// notification of new support tickets for users
			$options = array();
			$options['conditions'][] = array('user = ?', $user);
			$options['conditions'][] = array('has_been_read = ?', 0);
			if ($unreadTickets = Rakuun_DB_Containers::getSupportticketsContainer()->count($options)) {
				$url = App::get()->getInternModule()->getSubmodule('messages')->getUrl(array('category' => Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS));
				$this->addPanel($unreadTicketsLink = new GUI_Control_Link('unread_tickets_users', 'Du hast '.$unreadTickets.' ungelesene Supportnachrichten.', $url));
				if ($unreadTickets == 1)
					$unreadTicketsLink->setCaption('Du hast 1 ungelesene Supportnachricht.');
			}
			
			// notification of new support tickets for supporters
			if (Rakuun_TeamSecurity::get()->isInGroup($user, Rakuun_TeamSecurity::GROUP_SUPPORTERS)) {
				$options = array();
				$options['conditions'][] = array('is_answered = ?', 0);
				if ($unreadTickets = Rakuun_DB_Containers::getSupportticketsContainer()->count($options)) {
					$url = App::get()->getInternModule()->getSubmodule('support')->getUrl();
					$this->addPanel($unreadTicketsLink = new GUI_Control_Link('unread_tickets_supporters', $unreadTickets.' unbeantwortete Supportnachrichten.', $url));
					if ($unreadTickets == 1)
						$unreadTicketsLink->setCaption('1 unbeantwortete Supportnachricht.');
				}
			}
			
			
			// new global board posts
			$postingsTable = Rakuun_DB_Containers_Persistent::getBoardsGlobalPostingsContainer()->getTable();
			$lastVisitTable = Rakuun_DB_Containers_Persistent::getBoardsGlobalLastVisitedContainer()->getTable();
			$boardsTable = Rakuun_DB_Containers_Persistent::getBoardsGlobalContainer()->getTable();
			// count for all posts that have lastVisited information
			$options = array();
			$options['join'] = array($lastVisitTable);
			$options['conditions'][] = array($lastVisitTable.'.user_name = ?', Rakuun_User_Manager::getCurrentUser()->nameUncolored);
			$options['conditions'][] = array($lastVisitTable.'.round_number = ?', RAKUUN_ROUND_NAME);
			$options['conditions'][] = array($postingsTable.'.board = '.$lastVisitTable.'.board');
			$options['conditions'][] = array($postingsTable.'.date > '.$lastVisitTable.'.date');
			$options['conditions'][] = array($postingsTable.'.round_number = ?', RAKUUN_ROUND_NAME);
			$options['group'] = $postingsTable.'.id';
			$newPostingsCount = Rakuun_DB_Containers_Persistent::getBoardsGlobalPostingsContainer()->count($options);
			
			// count for all posts that have no lastVisited information
			$options = array();
			$subQuery = 'SELECT '.$boardsTable.'.id FROM '.$boardsTable.', '.$lastVisitTable.' WHERE '.$boardsTable.'.id = '.$lastVisitTable.'.board AND '.$lastVisitTable.'.user_name = \''.DB_Container::escape(Rakuun_User_Manager::getCurrentUser()->nameUncolored).'\' AND '.$lastVisitTable.'.round_number = \''.DB_Container::escape(RAKUUN_ROUND_NAME).'\' GROUP BY '.$boardsTable.'.id';
			$options['conditions'][] = array($postingsTable.'.board NOT IN ('.$subQuery.')');
			$options['conditions'][] = array($postingsTable.'.round_number = ?', RAKUUN_ROUND_NAME);
			$newPostingsCount += Rakuun_DB_Containers_Persistent::getBoardsGlobalPostingsContainer()->count($options);
			
			if ($newPostingsCount > 0) {
				$url = App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('global')->getUrl();
				$this->addPanel($unreadMessagesLink = new GUI_Control_Link('unread_global_board_posts', $newPostingsCount.' neue Beiträge im allgemeinen Forum.', $url));
				if ($newPostingsCount == 1)
					$unreadMessagesLink->setCaption('1 neuer Beitrag im allgemeinen Forum.');
			}
			
			// new alliance board posts
			if (App::get()->getInternModule()->getSubmodule('boards')->hasSubmodule('alliance') && Rakuun_User_Manager::getCurrentUser()->alliance) {
				$postingsTable = Rakuun_DB_Containers::getBoardsAlliancePostingsContainer()->getTable();
				$lastVisitTable = Rakuun_DB_Containers::getBoardsAllianceLastVisitedContainer()->getTable();
				$boardsTable = Rakuun_DB_Containers::getBoardsAllianceContainer()->getTable();
				// count for all posts that have lastVisited information
				$options = array();
				$options['join'] = array($lastVisitTable, $boardsTable);
				$options['conditions'][] = array($boardsTable.'.id = '.$postingsTable.'.board');
				$options['conditions'][] = array($postingsTable.'.board = '.$lastVisitTable.'.board');
				$options['conditions'][] = array($lastVisitTable.'.user = ?', Rakuun_User_Manager::getCurrentUser());
				$options['conditions'][] = array($boardsTable.'.alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
				$options['conditions'][] = array($postingsTable.'.date > '.$lastVisitTable.'.date');
				$options['group'] = $postingsTable.'.id';
				$newPostingsCount = Rakuun_DB_Containers::getBoardsAlliancePostingsContainer()->count($options);
				
				// count for all posts that have no lastVisited information
				$options = array();
				$options['join'] = array($boardsTable);
				$subQuery = 'SELECT '.$boardsTable.'.id FROM '.$boardsTable.', '.$lastVisitTable.' WHERE '.$boardsTable.'.id = '.$lastVisitTable.'.board AND '.$lastVisitTable.'.user = '.Rakuun_User_Manager::getCurrentUser()->getPK().' GROUP BY '.$boardsTable.'.id';
				$options['conditions'][] = array($postingsTable.'.board NOT IN ('.$subQuery.')');
				$options['conditions'][] = array($boardsTable.'.id = '.$postingsTable.'.board');
				$options['conditions'][] = array($boardsTable.'.alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
				$newPostingsCount += Rakuun_DB_Containers::getBoardsAlliancePostingsContainer()->count($options);
				
				if ($newPostingsCount > 0) {
					$url = App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('alliance')->getUrl();
					$this->addPanel($unreadMessagesLink = new GUI_Control_Link('unread_alliance_board_posts', $newPostingsCount.' neue Beiträge im Allianzforum.', $url));
					if ($newPostingsCount == 1)
						$unreadMessagesLink->setCaption('1 neuer Beitrag im Allianzforum.');
				}
			}
			
			// new meta board posts
			if (App::get()->getInternModule()->getSubmodule('boards')->hasSubmodule('meta') && isset(Rakuun_User_Manager::getCurrentUser()->alliance->meta)) {
				$postingsTable = Rakuun_DB_Containers::getBoardsMetaPostingsContainer()->getTable();
				$lastVisitTable = Rakuun_DB_Containers::getBoardsMetaLastVisitedContainer()->getTable();
				$boardsTable = Rakuun_DB_Containers::getBoardsMetaContainer()->getTable();
				// count for all posts that have lastVisited information
				$options = array();
				$options['join'] = array($lastVisitTable, $boardsTable);
				$options['conditions'][] = array($boardsTable.'.id = '.$postingsTable.'.board');
				$options['conditions'][] = array($postingsTable.'.board = '.$lastVisitTable.'.board');
				$options['conditions'][] = array($lastVisitTable.'.user = ?', Rakuun_User_Manager::getCurrentUser());
				$options['conditions'][] = array($boardsTable.'.meta = ?', Rakuun_User_Manager::getCurrentUser()->alliance->meta);
				$options['conditions'][] = array($postingsTable.'.date > '.$lastVisitTable.'.date');
				$options['group'] = $postingsTable.'.id';
				$newPostingsCount = Rakuun_DB_Containers::getBoardsMetaPostingsContainer()->count($options);
				
				// count for all posts that have no lastVisited information
				$options = array();
				$options['join'] = array($boardsTable);
				$subQuery = 'SELECT '.$boardsTable.'.id FROM '.$boardsTable.', '.$lastVisitTable.' WHERE '.$boardsTable.'.id = '.$lastVisitTable.'.board AND '.$lastVisitTable.'.user = '.Rakuun_User_Manager::getCurrentUser()->getPK().' GROUP BY '.$boardsTable.'.id';
				$options['conditions'][] = array($postingsTable.'.board NOT IN ('.$subQuery.')');
				$options['conditions'][] = array($boardsTable.'.id = '.$postingsTable.'.board');
				$options['conditions'][] = array($boardsTable.'.meta = ?', Rakuun_User_Manager::getCurrentUser()->alliance->meta);
				$newPostingsCount += Rakuun_DB_Containers::getBoardsMetaPostingsContainer()->count($options);
				
				if ($newPostingsCount > 0) {
					$url = App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('meta')->getUrl();
					$this->addPanel($unreadMessagesLink = new GUI_Control_Link('unread_meta_board_posts', $newPostingsCount.' neue Beiträge im Metaforum.', $url));
					if ($newPostingsCount == 1)
						$unreadMessagesLink->setCaption('1 neuer Beitrag im Metaforum.');
				}
			}
			
			// new admin board posts
			if (Rakuun_TeamSecurity::get()->hasPrivilege(Rakuun_User_Manager::getCurrentUser(), Rakuun_TeamSecurity::PRIVILEGE_BACKENDACCESS)) {
				$postingsTable = Rakuun_DB_Containers::getBoardsAdminPostingsContainer()->getTable();
				$lastVisitTable = Rakuun_DB_Containers::getBoardsAdminLastVisitedContainer()->getTable();
				$boardsTable = Rakuun_DB_Containers::getBoardsAdminContainer()->getTable();
				// count for all posts that have lastVisited information
				$options = array();
				$options['join'] = array($lastVisitTable, $boardsTable);
				$options['conditions'][] = array($boardsTable.'.id = '.$postingsTable.'.board');
				$options['conditions'][] = array($postingsTable.'.board = '.$lastVisitTable.'.board');
				$options['conditions'][] = array($lastVisitTable.'.user = ?', Rakuun_User_Manager::getCurrentUser());
				$options['conditions'][] = array($postingsTable.'.date > '.$lastVisitTable.'.date');
				$newPostingsCount = Rakuun_DB_Containers::getBoardsAdminPostingsContainer()->count($options);
				
				// count for all posts that have no lastVisited information
				$options = array();
				$options['join'] = array($boardsTable);
				$subQuery = 'SELECT '.$boardsTable.'.id FROM '.$boardsTable.', '.$lastVisitTable.' WHERE '.$boardsTable.'.id = '.$lastVisitTable.'.board AND '.$lastVisitTable.'.user = '.Rakuun_User_Manager::getCurrentUser()->getPK();
				$options['conditions'][] = array($postingsTable.'.board NOT IN ('.$subQuery.')');
				$options['conditions'][] = array($boardsTable.'.id = '.$postingsTable.'.board');
				$newPostingsCount += Rakuun_DB_Containers::getBoardsAdminPostingsContainer()->count($options);
				
				if ($newPostingsCount > 0) {
					$url = App::get()->getInternModule()->getSubmodule('boards')->getSubmodule('admin')->getUrl();
					$this->addPanel($unreadMessagesLink = new GUI_Control_Link('unread_admin_board_posts', $newPostingsCount.' neue Beiträge im Adminforum.', $url));
					if ($newPostingsCount == 1)
						$unreadMessagesLink->setCaption('1 neuer Beitrag im Adminforum.');
				}
			}
		}
		
		// news panel
		if ($user->news) {
			$this->addPanel(new GUI_Panel_Text('news', $user->news, 'News'));
			$user->news = '';
			Rakuun_User_Manager::update($user);
		}
	}
}

?>