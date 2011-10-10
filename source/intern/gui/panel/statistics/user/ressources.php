<?php

class Rakuun_Intern_GUI_Panel_Statistics_User_Ressources extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/ressources.tpl');
		
		$this->addPanel($capturedTable = new GUI_Panel_Table('captured_statistics'));
		$capturedTable->addHeader(array('Ressource', 'Anzahl'));
		
		$options = array();
		$options['properties'] = 'SUM(iron) as iron, SUM(beryllium) as beryllium, SUM(energy) as energy';
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('action = ?', Rakuun_Intern_Log::ACTION_RESSOURCES_FIGHT);
		$capturedRessources = Rakuun_DB_Containers::getLogUserRessourcetransferContainer()->selectFirst($options);
		
		$capturedTable->addLine(array('Eisen', Text::formatNumber($capturedRessources->iron)));
		$capturedTable->addLine(array('Beryllium', Text::formatNumber($capturedRessources->beryllium)));
		$capturedTable->addLine(array('Energie', Text::formatNumber($capturedRessources->energy)));
		$capturedTable->addTableCssClass('align_left', 0);
		
		$this->addPanel($lostTable = new GUI_Panel_Table('lost_statistics'));
		$lostTable->addHeader(array('Ressource', 'Anzahl'));
		
		$options = array();
		$options['properties'] = 'SUM(iron) as iron, SUM(beryllium) as beryllium, SUM(energy) as energy';
		$options['conditions'][] = array('sender = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('action = ?', Rakuun_Intern_Log::ACTION_RESSOURCES_FIGHT);
		$lostRessources = Rakuun_DB_Containers::getLogUserRessourcetransferContainer()->selectFirst($options);
		
		$lostTable->addLine(array('Eisen', Text::formatNumber($lostRessources->iron)));
		$lostTable->addLine(array('Beryllium', Text::formatNumber($lostRessources->beryllium)));
		$lostTable->addLine(array('Energie', Text::formatNumber($lostRessources->energy)));
		$lostTable->addTableCssClass('align_left', 0);
	}
}

?>