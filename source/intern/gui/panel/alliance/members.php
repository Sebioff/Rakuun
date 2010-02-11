<?php

/**
 * Panel that displays all members of an alliance.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Members extends GUI_Panel {
	public function __construct($name, Rakuun_DB_Alliance $alliance) {
		parent::__construct($name);

		$this->setTemplate(dirname(__FILE__).'/members.tpl');
		$this->params->members = $alliance->members;
	}
}

?>