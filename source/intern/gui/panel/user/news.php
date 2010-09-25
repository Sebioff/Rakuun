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