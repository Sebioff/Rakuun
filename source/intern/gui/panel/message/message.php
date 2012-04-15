<?php

/**
 * Displays a single IGM
 */
class Rakuun_Intern_GUI_Panel_Message extends GUI_Panel {
	private $message = null;
	
	public function __construct($name, Rakuun_Intern_IGM $message) {
		parent::__construct($name, '');
		
		$this->message = $message;
		$this->addClasses('rakuun_message');
	}
	
	public function init() {
		parent::init();
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$userPK = $user->getPK();
		
		if ($this->hasNoPrivilege($user)){
			return;
		}
		
		if (!$this->message->hasBeenRead && $this->message->user->getPK() == $userPK) {
			$this->message->hasBeenRead = true;
			$this->message->save();
		}
		
		$this->setTemplate(dirname(__FILE__).'/message.tpl');
		$this->addPanel(new GUI_Panel_Date('date', $this->message->time, 'Datum'));
		if (isset($this->message->sender->name))
			$this->addPanel(new Rakuun_GUI_Control_UserLink('sender', $this->message->sender, 'Sender'));
		else
			$this->addPanel(new GUI_Panel_Text('sender', $this->message->getSenderName(), 'Sender'));
		if ($this->message->user->getPK() == $userPK) {
			$this->addPanel(new GUI_Control_Submitbutton('delete', 'Löschen'));
			if ($this->message->isReported) {
				$this->addPanel(new GUI_Panel_Text('report', 'Diese Nachricht wurde gemeldet!'));
			} else if ($this->message->sender) {
				$this->addPanel(new GUI_Control_Submitbutton('report', 'Melden!'));
			}
		}
		switch ($this->message->type) { 
			case Rakuun_Intern_IGM::TYPE_PRIVATE:
				//oh here cann be wonderful a sponsor feature: adding signature, configurable in profile
				break;
			case Rakuun_Intern_IGM::TYPE_ALLIANCE:
				$this->addPanel(new GUI_Panel_Text('signature', 'Allianzrundmail', 'Signatur'));
				break;
			case Rakuun_Intern_IGM::TYPE_META:
				$this->addPanel(new GUI_Panel_Text('signature', 'Metarundmail', 'Signatur'));
				break;
			case Rakuun_Intern_IGM::TYPE_META:
				$this->addPanel(new GUI_Panel_Text('signature', 'Handel', 'Signatur'));
				break;
			case Rakuun_Intern_IGM::TYPE_FIGHT:
				$this->addPanel(new GUI_Panel_Text('signature', 'Kampfbericht', 'Signatur'));
				break;
			case Rakuun_Intern_IGM::TYPE_META:
				$this->addPanel(new GUI_Panel_Text('signature', 'Spionagebericht', 'Signatur'));
				break;
			default:
				//no signature
		}
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_Intern_IGM
	 */
	public function getMessage() {
		return $this->message;
	}
	
	public function onDelete() {
		Rakuun_DB_Containers::getMessagesContainer()->delete($this->message);
		$this->getModule()->redirect(App::get()->getInternModule()->getSubmodule('messages')->getUrl());
	}
	
	public function onReport() {
		$this->message->isReported = true;
		Rakuun_DB_Containers::getMessagesContainer()->save($this->message);		
	}
	
	private function hasNoPrivilege($user) {
		$userPK = $user->getPK();
		$msgUserPK = $this->message->user->getPK();
		$has_teamprivilege = Rakuun_TeamSecurity::get()->hasPrivilege($user, Rakuun_TeamSecurity::PRIVILEGE_REPORTEDMESSAGES);
		return $has_teamprivilege != "1" 
				&& $msgUserPK != $userPK && (!$this->message->sender || $this->message->sender->getPK() != $userPK);
	}
}

?>