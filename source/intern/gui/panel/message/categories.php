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

/**
 * Panel displaying all message categories
 */
class Rakuun_Intern_GUI_Panel_Message_Categories extends GUI_Panel {
	const CATEGORY_UNREAD = 'unread';
	const CATEGORY_SENT = 'sent';
	const CATEGORY_SUPPORTTICKETS = 'supporttickets';
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/categories.tpl');
		$this->addClasses('rakuun_messages_categories');
		
		$categoryLinks = array();
		$user = Rakuun_User_Manager::getCurrentUser();
		$messageCount = Rakuun_DB_Containers::getMessagesContainer()->count(self::getOptionsForCategory(self::CATEGORY_UNREAD));
		$this->addPanel($unreadLink = new GUI_Control_Link('unread', self::getNameForCategory(self::CATEGORY_UNREAD).' ('.$messageCount.')', App::get()->getInternModule()->getSubmodule('messages')->getUrl(array('category' => self::CATEGORY_UNREAD))));
		$categoryLinks[] = $unreadLink;
		foreach (Rakuun_Intern_IGM::getMessageTypes() as $messageType => $messageTypeName) {
			$options = array();
			$options['conditions'][] = array('user = ?', $user);
			$options['conditions'][] = array('type = ?', $messageType);
			$messageCount = Rakuun_DB_Containers::getMessagesContainer()->count($options);
			$url = App::get()->getInternModule()->getSubmodule('messages')->getUrl(array('category' => $messageType));
			$this->addPanel($categoryLink = new GUI_Control_Link($messageType, $messageTypeName.' ('.$messageCount.')', $url));
			$categoryLinks[] = $categoryLink;
		}
		
		// Category for supporttickets
		$supportticketCount = Rakuun_DB_Containers::getSupportticketsContainer()->count(self::getOptionsForCategory(self::CATEGORY_SUPPORTTICKETS));
		$this->addPanel($supportticketsLink = new GUI_Control_Link('suppporttickets', self::getNameForCategory(self::CATEGORY_SUPPORTTICKETS).' ('.$supportticketCount.')', App::get()->getInternModule()->getSubmodule('messages')->getUrl(array('category' => self::CATEGORY_SUPPORTTICKETS))));
		$categoryLinks[] = $supportticketsLink;
		
		$messageCount = Rakuun_DB_Containers::getMessagesContainer()->count(self::getOptionsForCategory(self::CATEGORY_SENT));
		$this->addPanel($sentLink = new GUI_Control_Link('sent', self::getNameForCategory(self::CATEGORY_SENT).' ('.$messageCount.')', App::get()->getInternModule()->getSubmodule('messages')->getUrl(array('category' => self::CATEGORY_SENT))));
		$categoryLinks[] = $sentLink;
		
		$this->params->categoryLinks = $categoryLinks;
	}
	
	public static function getOptionsForCategory($category) {
		$options = array();
		if ($category == Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_UNREAD) {
			$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
			$options['conditions'][] = array('has_been_read = ?', false);
		}
		elseif ($category == Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SENT) {
			$options['conditions'][] = array('sender = ?', Rakuun_User_Manager::getCurrentUser());
		}
		elseif ($category == Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS) {
			$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		}
		
		return $options;
	}
	
	public static function getNameForCategory($category) {
		if ($category == Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_UNREAD) {
			return 'Ungelesene IGMs';
		}
		elseif ($category == Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SENT) {
			return 'gesendete IGMs';
		}
		elseif ($category == Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS) {
			return 'Supporttickets';
		}
		else {
			$messageTypes = Rakuun_Intern_IGM::getMessageTypes();
			return $messageTypes[$category];
		}
	}
	
	public static function getMessageEnvelopeForCategory($category) {
		if ($category == Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS) {
			return 'Rakuun_Intern_GUI_Panel_Message_Support_Envelope';
		}
		else {
			return 'Rakuun_Intern_GUI_Panel_Message_BasicEnvelope';
		}
	}
}

?>