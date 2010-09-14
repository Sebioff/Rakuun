<?php

class Rakuun_Index_Panel_Endscore_TechnologyRecords extends GUI_Panel {
	public function init() {
		$this->setTemplate(dirname(__FILE__).'/technologyrecords.tpl');
		
		$this->addPanel($records = new GUI_Panel_Table('records'));
		$records->addHeader(array('Forschung', 'Stufe'));
		
		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies() as $technology) {
			if ($technology->getMaximumLevel() < 0) {
				$options = array();
				$options['properties'] = $technology->getInternalName().' AS highest_level';
				$options['order'] = $technology->getInternalName().' DESC';
				$records->addLine(array($technology->getName(), Rakuun_DB_Containers_Persistent::getTechnologiesContainer()->selectFirst($options)->highestLevel));
			}
		}
	}
}

?>