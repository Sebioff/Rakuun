<?php

/**
 * Panel displaying the "envelope" of a message -> short information
 */
class Rakuun_Intern_GUI_Panel_Message_BasicEnvelope extends Rakuun_Intern_GUI_Panel_Message_Envelope {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/basicenvelope.tpl');
		$this->addPanel(new GUI_Panel_Date('date', $this->getMessage()->time, 'Datum'));
		$this->addPanel(new Rakuun_GUI_Control_UserLink('receiver', $this->getMessage()->user, $this->getMessage()->get('user'), 'Empfänger'));
		$this->addPanel(new Rakuun_GUI_Control_UserLink('sender', $this->getMessage()->sender, $this->getMessage()->get('sender'), 'Sender'));
		$this->getSelectionList()->addItemCheckbox($selectionCheckbox = new GUI_Control_CheckBox('checkbox'.$this->getMessage()->getPK(), $this->getMessage()->getPK()));
		$this->params->url = App::get()->getInternModule()->getSubmodule('messages')->getSubmodule('display')->getURL(array('id' => $this->getMessage()->getPK()));
		$this->params->selectionCheckbox = $selectionCheckbox;
	}
}

?>