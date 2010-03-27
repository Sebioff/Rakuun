<?php

class Rakuun_Intern_GUI_Panel_Statistics_User_DestroyedUnits extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/destroyedunits.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		
		$table->addHeader(array('Einheit', 'Angriff', 'Verteidigung', 'Total'));
		
		$properties = array();
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit)
			$properties[] = 'SUM('.$unit->getInternalName().') as '.$unit->getInternalName();
		
		$options = array();
		$options['properties'] = implode(', ', $properties);
		$options['conditions'][] = array('opponent = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_DEFENDER);
		$destroyedInAttack = Rakuun_DB_Containers::getLogFightsContainer()->selectFirst($options);
		
		$options = array();
		$options['properties'] = implode(', ', $properties);
		$options['conditions'][] = array('opponent = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('role = ?', Rakuun_Intern_Log_Fights::ROLE_ATTACKER);
		$destroyedInDefense = Rakuun_DB_Containers::getLogFightsContainer()->selectFirst($options);
		
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			$unitsDestroyedInAttack = $destroyedInAttack->{Text::underscoreToCamelCase($unit->getInternalName())};
			$unitsDestroyedInDefense = $destroyedInDefense->{Text::underscoreToCamelCase($unit->getInternalName())};
			$total = $unitsDestroyedInAttack + $unitsDestroyedInDefense;
			$table->addLine(array($unit->getNameForAmount(2), GUI_Panel_Number::formatNumber($unitsDestroyedInAttack), GUI_Panel_Number::formatNumber($unitsDestroyedInDefense), GUI_Panel_Number::formatNumber($total)));
		}
	}

}

?>