<?php

class Rakuun_Index_Panel_Endscore_BiggestFights extends GUI_Panel {
	public function init() {
		$this->setTemplate(dirname(__FILE__).'/biggestfights.tpl');
		
		$properties = array('user', 'opponent', 'time', 'type', 'role');
		$totalForceProperty = array();
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			$properties[] = 'SUM('.$unit->getInternalName().') AS '.$unit->getInternalName().'_sum';
			$totalForceProperty[] = 'SUM('.$unit->getInternalName().') * '.$unit->getBaseArmyStrength();
		}
		
		$options = array();
		$options['properties'] = implode(', ', $properties).', '.implode(' + ', $totalForceProperty).' AS total_force';
		$options['group'] = 'fight_id';
		$options['order'] = 'total_force DESC';
		$options['limit'] = '5';
		$this->params->fights = Rakuun_DB_Containers_Persistent::getLogFightsContainer()->select($options);
	}
}

?>