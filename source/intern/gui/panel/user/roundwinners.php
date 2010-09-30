<?php

class Rakuun_Intern_GUI_Panel_User_RoundWinners extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/roundwinners.tpl');
		$this->addPanel($table = new GUI_Panel_Table('winners'));
		$table->addHeader(array('Runde', 'Siegermeta', 'Rundendauer'));
		$options = array();
		$options['order'] = 'end_time DESC';
		foreach (Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->select($options) as $roundInformation) {
			$table->addLine(array($roundInformation->roundName, $roundInformation->winningMeta, round(($roundInformation->endTime - $roundInformation->startTime) / 60 / 60 / 24).' Tage'));
		}
	}
}

?>