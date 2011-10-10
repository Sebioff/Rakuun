<?php

class Rakuun_Intern_GUI_Panel_Statistics_User_LostBuildings extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/lostbuildings.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		
		$table->addHeader(array('Gebäude', 'Verlorene Stufen'));
		
		$options = array();
		$options['properties'] = 'SUM(delta_level) as lost_levels, building';
		$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
		$options['conditions'][] = array('event_type = ?', Rakuun_Intern_Event::EVENT_TYPE_BUILDING_DESTROY);
		$options['group'] = 'building';
		foreach (Rakuun_DB_Containers::getLogBuildingsContainer()->select($options) as $lostBuildingLevels) {
			$building = Rakuun_Intern_Production_Factory::getBuilding($lostBuildingLevels->building);
			$line = array($building->getName(), Text::formatNumber(abs($lostBuildingLevels->lostLevels)));
			$table->addLine($line);
		}
		$table->addTableCssClass('align_left', 0);
	}
}

?>