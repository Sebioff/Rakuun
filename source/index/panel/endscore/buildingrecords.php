<?php

class Rakuun_Index_Panel_Endscore_BuildingRecords extends GUI_Panel {
	public function init() {
		$this->setTemplate(dirname(__FILE__).'/buildingrecords.tpl');
		
		$this->addPanel($records = new GUI_Panel_Table('records'));
		$records->addHeader(array('Gebäude', 'Stufe'));
		
		foreach (Rakuun_Intern_Production_Factory::getAllBuildings() as $building) {
			if ($building->getMaximumLevel() < 0) {
				$options = array();
				$options['properties'] = $building->getInternalName().' AS highest_level';
				$options['order'] = $building->getInternalName().' DESC';
				$records->addLine(array($building->getName(), Rakuun_DB_Containers_Persistent::getBuildingsContainer()->selectFirst($options)->highestLevel));
			}
		}
	}
}

?>