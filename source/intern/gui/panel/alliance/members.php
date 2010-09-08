<?php

/**
 * Panel that displays all members of an alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Members extends GUI_Panel {
	private $alliance = null;
	
	public function __construct($name, Rakuun_DB_Alliance $alliance) {
		parent::__construct($name);

		$this->setTemplate(dirname(__FILE__).'/members.tpl');
		$this->alliance = $alliance;
		$this->params->members = $alliance->members;
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_DB_Alliance
	 */
	public function getAlliance() {
		return $this->alliance;
	}
}

?>