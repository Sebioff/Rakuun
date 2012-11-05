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
 * Shows all reported Messages
 * @author dr.dent
 */
class Rakuun_Intern_GUI_Panel_Admin_ReportedMessages extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/reportedmessages.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('reported_messages', 'Gemeldete Nachrichten'));
		$table->addHeader(array('Empfänger', 'Sender', 'Betreff', 'Datum'));
		$options['conditions'][] = array('is_reported = ?', true);
		foreach (Rakuun_DB_Containers::getMessagesContainer()->select($options) as $reported_message) {
			$link = new GUI_Control_Link('msg_'.$reported_message->getPK(), $reported_message->subject, App::get()->getInternModule()->getSubmodule('messages')->getSubmodule('display')->getURL(array('id' => $reported_message->id)));
			$table->addLine(array($reported_message->user->name, $reported_message->sender->name, $link, date('d.m.Y, H:i:s', $reported_message->time)));
		}
		
	}
}

?>