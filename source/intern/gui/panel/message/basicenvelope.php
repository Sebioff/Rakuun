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
		if (in_array(Text::toUpperCase($this->getMessage()->senderName), Rakuun_Intern_IGM::getReservedNames()))
			$this->addPanel(new GUI_Panel_Text('sender', $this->getMessage()->senderName, 'Sender'));
		else
			$this->addPanel(new Rakuun_GUI_Control_UserLink('sender', $this->getMessage()->sender, $this->getMessage()->get('sender'), 'Sender'));
		$this->getSelectionList()->addItemCheckbox($selectionCheckbox = new GUI_Control_CheckBox('checkbox'.$this->getMessage()->getPK(), $this->getMessage()->getPK()));
		$this->params->url = App::get()->getInternModule()->getSubmodule('messages')->getSubmodule('display')->getURL(array('id' => $this->getMessage()->getPK()));
		$this->params->selectionCheckbox = $selectionCheckbox;
		
		$this->addPanel($content = new Rakuun_GUI_Panel_Box_Collapsible('content', new MessageContent('content', $this->getMessage()), 'Anzeigen', true));
		$content->enableSaveCollapsedState(false);
		$content->addClasses('rakuun_message_contentpanel');
		$content->setAnimationSpeed(2);
	}
}

class MessageContent extends GUI_Panel {
	private $message;
	
	public function __construct($name, DB_Record $message) {
		parent::__construct($name);
		$this->message = $message;
	}
	
	public function init() {
		parent::init();
		
		$this->addPanel(new GUI_Panel_Text('text', Rakuun_Text::formatPlayerText($this->message->text, false)));
		
		if (!$this->message->hasBeenRead && $this->message->user->getPK() == Rakuun_User_Manager::getCurrentUser()->getPK()) {
			$this->message->hasBeenRead = true;
			$this->message->save();
		}
	}
}

?>