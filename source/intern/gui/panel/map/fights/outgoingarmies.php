<?php

class Rakuun_Intern_GUI_Panel_Map_Fights_OutgoingArmies extends GUI_Panel {
	private $armiesPanels = array();
	
	public function init() {
		parent::init();
		
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['order'] = 'target_time ASC';
		foreach (Rakuun_DB_Containers::getArmiesContainer()->select($options) as $army) {
			$this->addPanel($armyPanel = new Rakuun_Intern_GUI_Panel_Map_Fights_OutgoingArmy('army_'.$army->getPK(), $army));
			$this->armiesPanels[] = $armyPanel;
		}
		
		$this->setTemplate(dirname(__FILE__).'/outgoingarmies.tpl');
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getArmiesPanels() {
		return $this->armiesPanels;
	}
}

?>