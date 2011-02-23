<?php

/**
 * Panel displaying the "envelope" of a message -> short information
 */
abstract class Rakuun_Intern_GUI_Panel_Message_Envelope extends GUI_Panel {
	private $message = null;
	private $selectionList = null;
	
	public function __construct($name, DB_Record $message, GUI_Control_CheckBoxList $selectionList = null) {
		parent::__construct($name, '');
		
		$this->message = $message;
		$this->selectionList = $selectionList;
		$this->addClasses('rakuun_message_envelope', 'clearfix');
		if (!$this->message->hasBeenRead)
			$this->addClasses('rakuun_message_unread');
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return DB_Record
	 */
	public function getMessage() {
		return $this->message;
	}
	
	/**
	 * @return GUI_Control_CheckBoxList
	 */
	public function getSelectionList() {
		return $this->selectionList;
	}
}

?>