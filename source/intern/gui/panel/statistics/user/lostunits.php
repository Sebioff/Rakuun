<?php

class Rakuun_Intern_GUI_Panel_Statistics_User_LostUnits extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/lostunits.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		
		$table->addHeader(array('Einheit', 'Angriff', 'Verteidigung', 'Total'));
		
		$properties = array();
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit)
			$properties[] = 'SUM('.$unit->getInternalName().') as '.$unit->getInternalName();
		
		$options = array();
		$options['properties'] = implode(', ', $properties);
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_ATTACKER);
		$lostInAttack = Rakuun_DB_Containers::getLogFightsContainer()->selectFirst($options);
		
		$options = array();
		$options['properties'] = implode(', ', $properties);
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_DEFENDER);
		$lostInDefense = Rakuun_DB_Containers::getLogFightsContainer()->selectFirst($options);
		
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			$unitsLostInAttack = $lostInAttack->{Text::underscoreToCamelCase($unit->getInternalName())};
			$unitsLostInDefense = $lostInDefense->{Text::underscoreToCamelCase($unit->getInternalName())};
			$total = $unitsLostInAttack + $unitsLostInDefense;
			$table->addLine(array($unit->getNameForAmount(2), Text::formatNumber($unitsLostInAttack), Text::formatNumber($unitsLostInDefense), Text::formatNumber($total)));
		}
		$table->addTableCssClass('align_left', 0);
	}
}

?>