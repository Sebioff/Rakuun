<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

class Rakuun_Intern_Module_Messages_Display extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$message = null;
		if ($id = (int)$this->getParam('id')) {
			$message = Rakuun_DB_Containers::getMessagesContainer()->selectByPK($id);
			$user = Rakuun_User_Manager::getCurrentUser();
			
			if (!$message || (
					(!$message->isReported || !Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_REPORTEDMESSAGES))
					&& $message->user->getPK() != $user->getPK() && ($message->sender == null || $message->sender->getPK() != $user->getPK())
				)) {
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