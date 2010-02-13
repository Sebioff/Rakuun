<?php

class Rakuun_Intern_GUI_Panel_Statistics_Military extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/military.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		
		$table->addHeader(array('Name', 'Wert'));
		
		$line = array('Laufende Angriffe:', GUI_Panel_Number::formatNumber(Rakuun_Intern_Statistics::noOfRunningAtts()));
		$table->addLine($line);
		
		$line = array('Bisher durchgeführte Angriffe:', GUI_Panel_Number::formatNumber(Rakuun_Intern_Statistics::noOfAtts()));
		$table->addLine($line);
		
		$options = array();
		$properties = array();
		$units = Rakuun_Intern_Production_Factory::getAllUnits();
		foreach ($units as $unit)
			$properties[] = 'SUM('.$unit->getInternalName().') AS '.$unit->getInternalName().'_sum';
		$options['properties'] = implode(', ', $properties);
		$unitAmounts = Rakuun_DB_Containers::getUnitsContainer()->selectFirst($options);
		foreach ($units as $unit) {
			$line = array($unit->getNameForAmount(2), GUI_Panel_Number::formatNumber($unitAmounts->{Text::underscoreToCamelCase($unit->getInternalName().'_sum')}));
			$table->addLine($line);
		}
		
		$usersCount = Rakuun_Intern_Statistics::noOfPlayers();
		foreach ($units as $unit) {
			$line = array('&oslash; '.$unit->getNameForAmount(2).' / Spieler', GUI_Panel_Number::formatNumber(round($unitAmounts->{Text::underscoreToCamelCase($unit->getInternalName().'_sum')} / $usersCount)));
			$table->addLine($line);
		}
	}

}

?>