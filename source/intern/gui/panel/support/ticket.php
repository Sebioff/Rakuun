<?php

/**
 * Displays a single supportticket
 */
class Rakuun_Intern_GUI_Panel_Support_Ticket extends GUI_Panel {
	private $supportticket = null;
	
	public function __construct($name, DB_Record $supportticket) {
		parent::__construct($name, '');
		
		$this->supportticket = $supportticket;
		$this->addClasses('rakuun_message');
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/ticket.tpl');
		$this->addPanel(new GUI_Panel_Date('date', $this->supportticket->time, 'Datum'));
		$this->addPanel(new Rakuun_GUI_Control_UserLink('user', $this->supportticket->user, 'User'));
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Record
	 */
	public function getTicket() {
		return $this->supportticket;
	}
}

?>