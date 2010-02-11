<?php

/**
 * Panel displaying the "envelope" of a ticket -> short information
 */
class Rakuun_Intern_GUI_Panel_Message_Support_Envelope extends Rakuun_Intern_GUI_Panel_Message_Envelope {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/envelope.tpl');
		$this->addPanel(new GUI_Panel_Date('date', $this->getMessage()->time, 'Datum'));
		$this->addPanel(new GUI_Panel_Text('supporter', $this->getMessage()->supporter ? $this->getMessage()->supporter->name : 'kein Supporter', 'Supporter'));
		$this->params->url = App::get()->getInternModule()->getSubmodule('messages')->getSubmodule('display')->getURL(array('ticketID' => $this->getMessage()->getPK()));
	}
}

?>