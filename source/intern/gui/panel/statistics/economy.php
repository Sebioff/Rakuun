<?php

class Rakuun_Intern_GUI_Panel_Statistics_Economy extends GUI_Panel {
	public function init() {
		parent::init();
		$this->setTemplate(dirname(__FILE__).'/economy.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('statistics'));
		$table->addTableCssClass('align_left', 0);
		$table->addHeader(array('Name', 'Wert'));
		
		$options = array();
		$properties = array();
		$buildings = Rakuun_Intern_Production_Factory::getAllBuildings();
		foreach ($buildings as $building) {
			if ($building->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INVISIBLE_FOR_SPIES) === true)
				continue;
			
			$properties[] = 'SUM('.$building->getInternalName().') AS '.$building->getInternalName().'_sum';
		}
		$options['properties'] = implode(', ', $properties);
		$buildingAmounts = Rakuun_DB_Containers::getBuildingsContainer()->selectFirst($options);
		$usersCount = Rakuun_Intern_Statistics::noOfPlayers();
		foreach ($buildings as $building) {
			if ($building->getAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INVISIBLE_FOR_SPIES) === true)
				continue;
			
			$line = array('&oslash; Stufe '.$building->getName(), GUI_Panel_Number::formatNumber(round($buildingAmounts->{Text::underscoreToCamelCase($building->getInternalName().'_sum')} / $usersCount)));
			$table->addLine($line);
		}
	}

}

?>