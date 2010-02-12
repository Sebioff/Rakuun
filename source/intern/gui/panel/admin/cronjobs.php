<?php

class Rakuun_Intern_GUI_Panel_Admin_Cronjobs extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/cronjobs.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('cronjobs', 'Cronjobs'));
		$table->addHeader(array('Cronjob', 'Letzte Ausführung', 'Erfolgreich', 'Dauer (s)'));
		foreach (Rakuun_DB_Containers::getCronjobsContainer()->select() as $cronjob) {
			$table->addLine(array($cronjob->identifier, date('d.m.Y, H:i:s', $cronjob->lastExecution), $cronjob->lastExecutionSuccessful, $cronjob->lastExecutionDuration));
		}
	}
}

?>