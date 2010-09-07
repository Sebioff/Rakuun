<?php

class Rakuun_Intern_GUI_Panel_Statistics_User_Fights extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/fights.tpl');
		
		$this->addPanel($wonTable = new GUI_Panel_Table('won_statistics'));
		$wonTable->addHeader(array('Angriff', 'Verteidigung'));
		
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('type = ?', Rakuun_Intern_Log_Fights::TYPE_WON);
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_ATTACKER);
		$wonAttack = Rakuun_DB_Containers::getLogFightsContainer()->count($options);
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('type = ?', Rakuun_Intern_Log_Fights::TYPE_WON);
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_DEFENDER);
		$wonDefense = Rakuun_DB_Containers::getLogFightsContainer()->count($options);
		
		$wonTable->addLine(array(GUI_Panel_Number::formatNumber($wonAttack), GUI_Panel_Number::formatNumber($wonDefense)));
		$wonTable->addTableCssClass('align_left', 0);
		
		$this->addPanel($lostTable = new GUI_Panel_Table('lost_statistics'));
		$lostTable->addHeader(array('Angriff', 'Verteidigung'));
		
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('type = ?', Rakuun_Intern_Log_Fights::TYPE_LOST);
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_ATTACKER);
		$lostAttack = Rakuun_DB_Containers::getLogFightsContainer()->count($options);
		$options = array();
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('type = ?', Rakuun_Intern_Log_Fights::TYPE_LOST);
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_DEFENDER);
		$lostDefense = Rakuun_DB_Containers::getLogFightsContainer()->count($options);
		
		$lostTable->addLine(array(GUI_Panel_Number::formatNumber($lostAttack), GUI_Panel_Number::formatNumber($lostDefense)));
		$lostTable->addTableCssClass('align_left', 0);
	}
}

?>
