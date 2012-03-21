<?php

class Rakuun_Intern_Module_Messages_Display extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$message = null;
		if ($id = (int)$this->getParam('id')) {
			$message = Rakuun_DB_Containers::getMessagesContainer()->selectByPK($id);
			$user = Rakuun_User_Manager::getCurrentUser();
			
			if (!$message 
				|| (Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_REPORTEDMESSAGES) != 1) && ($message->user->getPK() != $user->getPK() && ($message->sender == null || $message->sender->getPK() != $user->getPK()))) {
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
			$this->contentPanel->addPanel($messageBox = new Rakuun_GUI_Panel_Box('message', new Rakuun_Intern_GUI_Panel_Message('message', $message)));
			$messageBox->addClasses('rakuun_box_message');
			if ($message->canBeRepliedTo()) {
				$replyTo = array($message->sender);
				if ($message->type == Rakuun_Intern_IGM::TYPE_PRIVATE && $this->getParam('replyTo') == 'all') {
					foreach ($message->getAttachmentsOfType(Rakuun_Intern_IGM::ATTACHMENT_TYPE_COPYRECIPIENT) as $copyRecipient) {
						$replyTo[] = Rakuun_DB_Containers::getUserContainer()->selectByPK($copyRecipient->value);
					}
				}
				$this->contentPanel->addPanel($replyBox = new Rakuun_GUI_Panel_Box('reply', new Rakuun_Intern_GUI_Panel_Message_Send('reply', 'Antworten', $message, $replyTo)), 'Antworten');
				$replyBox->addClasses('rakuun_box_message_reply');
				$this->contentPanel->addPanel($historyBox = new Rakuun_GUI_Panel_Box_Collapsible('history', new Rakuun_Intern_GUI_Panel_Message_History('history', $message), 'History', true));
				$historyBox->addClasses('rakuun_box_message_history');
				$historyBox->enableSaveCollapsedState(false);
				$historyBox->setAnimationSpeed(2);
			}
		}
		
		if ($ticket) {
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_Message_Support_Ticket('ticket', $ticket));
			$this->contentPanel->addPanel($replyBox = new Rakuun_GUI_Panel_Box('replyticket', new Rakuun_Intern_GUI_Panel_Message_Support('replyticket', 'Antworten', $ticket)), 'Antworten');
			$replyBox->addClasses('rakuun_box_message_reply');
		}
	}
}

?>