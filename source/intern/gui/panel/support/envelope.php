<?php

/**
 * Panel displaying the "envelope" of a ticket -> short information
 */
class Rakuun_Intern_GUI_Panel_Support_Envelope extends GUI_Panel {
	private $supportticket = null;
	
	public function __construct($name, DB_Record $supportticket) {
		parent::__construct($name, '');
		
		$this->supportticket = $supportticket;
		$this->addClasses('rakuun_message_envelope');
		if (!$this->supportticket->isAnswered)
			$this->addClasses('rakuun_message_unread');
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/envelope.tpl');
		$this->addPanel(new GUI_Panel_Date('date', $this->supportticket->time, 'Datum'));
		$this->addPanel(new Rakuun_GUI_Control_UserLink('user', $this->supportticket->user, $this->supportticket->get('user'), 'User'));
		$this->params->url = App::get()->getInternModule()->getSubmodule('support')->getSubmodule('display')->getURL(array('id' => $this->getTicket()->getPK()));
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