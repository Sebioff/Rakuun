<?php

/**
 * Displays all ressource (incomming) transfers of a given user
 */
class Rakuun_Intern_GUI_Panel_Multihunting_RessourceLog extends GUI_Panel {
	private $user = null;
	
	public function __construct($name, Rakuun_DB_User $user = null, $title = '') {
		parent::__construct($name, $title);
		
		$this->user = $user;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/ressourcelog.tpl');
		if ($this->user) {
			$this->addPanel($log = new GUI_Panel_Table('log', 'eingehende Ressourcen-Transfers'));
			$log->addHeader(array('Sender', 'Aktion', 'Zeit', 'Eisen', 'Beryllium', 'Energie', 'Leute', 'IP', 'Hostname', 'Browser'));
			$options = array();
			$options['order'] = 'time DESC';
			foreach (Rakuun_DB_Containers::getLogUserRessourcetransferContainer()->selectByUser($this->user, $options) as $ressourcetransfer) {
				$date = new GUI_Panel_Date('date'.$ressourcetransfer->getPK(), $ressourcetransfer->time);
				$sender = new Rakuun_GUI_Control_UserLink('user'.$ressourcetransfer->getPK(), $ressourcetransfer->sender, $ressourcetransfer->get('sender'));
				$ip = new GUI_Control_Link('url'.$ressourcetransfer->getPK(), $ressourcetransfer->ip, 'http://www.ip-adress.com/whois/'.$ressourcetransfer->ip);
				$log->addLine(array($sender, Rakuun_Intern_Log::getActionDescription($ressourcetransfer->action), $date, $ressourcetransfer->iron, $ressourcetransfer->beryllium, $ressourcetransfer->energy, $ressourcetransfer->people, $ip, $ressourcetransfer->hostname, $ressourcetransfer->browser));
			}
		}
	}
}

?>