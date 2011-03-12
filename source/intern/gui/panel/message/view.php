<?php

/**
 * Views all available IGMs for a category
 */
class Rakuun_Intern_GUI_Panel_Message_View extends GUI_Panel_PageView {
	const SELECTION_ALL = 1;
	const SELECTION_SELECTED = 2;
	
	const ACTION_DELETE = 1;
	const ACTION_MARK_AS_READ = 2;
	// TODO add action: move to notes
	
	private $messagesContainer = null;
	private $envelopes = array();
	private $category;
	private $viewSupporttickets = false;
	
	public function __construct($name, $messageType = Rakuun_Intern_IGM::TYPE_PRIVATE) {
		$messagesContainer = Rakuun_DB_Containers::getMessagesContainer();
		$this->category = $messageType;
		
		$filter = array();
		if (array_key_exists($messageType, Rakuun_Intern_IGM::getMessageTypes())) {
			$filter['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
			$filter['conditions'][] = array('type = ?', $messageType);
		}
		else {
			$filter = DB_Container::mergeOptions($filter, Rakuun_Intern_GUI_Panel_Message_Categories::getOptionsForCategory($messageType));
		}
		
		if ($this->category == Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS) {
			$messagesContainer = Rakuun_DB_Containers::getSupportticketsContainer();
		}
		
		$this->messagesContainer = $messagesContainer->getFilteredContainer($filter);
		
		parent::__construct($name, $this->messagesContainer, '');
	}
	
	public function init() {
		parent::init();
		
		$filterOptions = $this->getOptions();
		$filterOptions['order'] = 'id DESC';
		
		$this->addPanel($selectedMessages = new GUI_Control_CheckBoxList('selected_messages'));
		
		foreach ($this->getMessagesContainer()->select($filterOptions) as $message) {
			$envelope = Rakuun_Intern_GUI_Panel_Message_Categories::getMessageEnvelopeForCategory($this->category);
			$this->addEnvelope($envelopeBox = new Rakuun_GUI_Panel_Box('message_'.$message->getPK(), new $envelope('message_'.$message->getPK(), $message, $selectedMessages)));
			$envelopeBox->addClasses('rakuun_box_message_envelope');
		}
		
		if ($this->category != Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SENT && $this->category != Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS) {
			$selections = array(
				self::SELECTION_SELECTED	=> 'Markierte Nachrichten',
				self::SELECTION_ALL			=> 'Alle Nachrichten in "'.Rakuun_Intern_GUI_Panel_Message_Categories::getNameForCategory($this->category).'"'
			);
			$this->addPanel(new GUI_Control_DropDownBox('selections', $selections));
			$actions = array(
				self::ACTION_DELETE 		=> 'löschen',
				self::ACTION_MARK_AS_READ	=> 'als gelesen markieren'
			);
			$this->addPanel(new GUI_Control_DropDownBox('actions', $actions));
			$this->addPanel($executeActionsButton = new GUI_Control_SubmitButton('execute_actions', 'OK'));
			$executeActionsButton->setConfirmationMessage('Wirklich die gewählte Aktion durchführen?');
		}
		
		$this->setTemplate(dirname(__FILE__).'/view.tpl');
	}
	
	// CALLBACKS ---------------------------------------------------------------
	public function onExecuteActions() {
		if ($this->hasErrors())
			return;
			
		$options = array();
		if ($this->selections->getKey() == self::SELECTION_SELECTED) {
			$selectedIDs = array();
			foreach ($this->selectedMessages->getSelectedItems() as $selectedItem)
				$selectedIDs[] = DB_Container::escape($selectedItem->getValue());
			if (!$selectedIDs)
				return;
			$options['conditions'][] = array('id IN ('.implode(', ', $selectedIDs).')');
		}
		
		if ($this->actions->getKey() == self::ACTION_DELETE) {
			$this->getMessagesContainer()->delete($options);
		}
		elseif ($this->actions->getKey() == self::ACTION_MARK_AS_READ) {
			$options['properties'] = 'has_been_read = 1';
			$this->getMessagesContainer()->updateByOptions($options);
		}
		
		$this->getModule()->invalidate();
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getEnvelopes() {
		return $this->envelopes;
	}
	
	public function getMessagesContainer() {
		return $this->messagesContainer;
	}
	
	public function addEnvelope(GUI_Panel $envelope) {
		$this->addPanel($envelope);
		$this->envelopes[] = $envelope;
	}
}

?>