<?php

/**
 * Displays a single supportticket
 */
class Rakuun_Intern_GUI_Panel_Message_Support_Ticket extends GUI_Panel {
	private $supportticket = null;
	
	public function __construct($name, DB_Record $supportticket) {
		parent::__construct($name, '');
		
		$this->supportticket = $supportticket;
		$this->addClasses('rakuun_message');
	}
	
	public function init() {
		parent::init();
		
		if ($this->supportticket->user->getPK() != Rakuun_User_Manager::getCurrentUser()->getPK())
			return;
		
		if (!$this->supportticket->hasBeenRead) {
			$this->supportticket->hasBeenRead = true;
			$this->supportticket->save();
		}
		
		$this->setTemplate(dirname(__FILE__).'/ticket.tpl');
		$this->addPanel(new GUI_Panel_Date('date', $this->supportticket->time, 'Datum'));
		$this->addPanel(new Rakuun_GUI_Control_UserLink('supporter', $this->supportticket->supporter, 'Supporter'));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Record
	 */
	public function getSupportticket() {
		return $this->supportticket;
	}
}

?>