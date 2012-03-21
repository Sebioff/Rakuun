<?php

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