<?php

/**
 * Panel for showing the history of an IGM
 */
class Rakuun_Intern_GUI_Panel_Message_History extends GUI_Panel {
	private $historyOfMessage = null;
	
	public function __construct($name, DB_Record $historyOfMessage) {
		parent::__construct($name, '');
			
		$this->historyOfMessage = $historyOfMessage;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/history.tpl');
		
		$options = array();
		$options['conditions'][] = array('type = ?', Rakuun_Intern_IGM::ATTACHMENT_TYPE_CONVERSATION);
		$options['conditions'][] = array('message = ?', $this->historyOfMessage);
		$conversation = Rakuun_DB_Containers::getMessagesAttachmentsContainer()->selectFirst($options);
		
		$igmPanels = array();
		$attachmentsTable = Rakuun_DB_Containers::getMessagesAttachmentsContainer()->getTable();
		$messagesTable = Rakuun_DB_Containers::getMessagesContainer()->getTable();
		$options = array();
		$options['join'] = array($attachmentsTable);
		$options['conditions'][] = array($attachmentsTable.'.type = ?', Rakuun_Intern_IGM::ATTACHMENT_TYPE_CONVERSATION);
		$options['conditions'][] = array($attachmentsTable.'.value = ?', $conversation->value);
		$options['conditions'][] = array($messagesTable.'.id = '.$attachmentsTable.'.message');
		$options['conditions'][] = array('user = ? OR sender = ?', Rakuun_User_Manager::getCurrentUser(), Rakuun_User_Manager::getCurrentUser());
		$options['order'] = 'ID DESC';
		foreach (Rakuun_DB_Containers::getMessagesContainer()->select($options) as $igm) {
			$this->addPanel($igmPanel = new Rakuun_Intern_GUI_Panel_Message('message'.$igm->getPK(), $igm));
			$igmPanel->addClasses('rakuun_box_message');
			$igmPanels[] = $igmPanel;
		}
		$this->params->igmPanels = $igmPanels;
	}
}

?>