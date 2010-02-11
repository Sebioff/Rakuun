<?php

class Rakuun_Intern_Module_Messages_Display extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$message = null;
		if ($id = (int)$this->getParam('id')) {
			$message = Rakuun_DB_Containers::getMessagesContainer()->selectByPK($id);
			if (!$message || ($message->user->getPK() != Rakuun_User_Manager::getCurrentUser()->getPK() && ($message->sender == null || $message->sender->getPK() != Rakuun_User_Manager::getCurrentUser()->getPK()))) {
				$this->redirect($this->getParent()->getUrl());
			}
		}
		$ticket = null;
		if ($ticketID = (int)$this->getParam('ticketID')) {
			$ticket = Rakuun_DB_Containers::getSupportticketsContainer()->selectByPK($ticketID);
			if (!$ticket || ($ticket->user->getPK() != Rakuun_User_Manager::getCurrentUser()->getPK())) {
				$this->redirect($this->getParent()->getUrl());
			}
		}
		
		$this->setPageTitle('Nachricht');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/display.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Message_Categories('categories', 'Nachrichtenkategorien'));
		if ($message) {
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Message('message', $message));
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('reply', new Rakuun_Intern_GUI_Panel_Message_Send('reply', 'Antworten', $message)), 'Antworten');
		}
		
		if ($ticket) {
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Message_Support_Ticket('ticket', $ticket));
			if ($ticket->is_answered) {
				$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('replyticket', new Rakuun_Intern_GUI_Panel_Message_Support('replyticket', 'Antworten', $ticket)), 'Antworten');
			}
		}
	}
}

?>