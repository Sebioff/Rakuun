<?php

class Rakuun_Index_Panel_Endscore_TechnologyRecords extends GUI_Panel {
	public function init() {
		$this->setTemplate(dirname(__FILE__).'/technologyrecords.tpl');
		
		$this->addPanel($records = new GUI_Panel_Table('records'));
		$records->addHeader(array('Forschung', 'Spieler', 'Stufe'));
		
		foreach (Rakuun_Intern_Production_Factory::getAllTechnologies() as $technology) {
			if ($technology->getMaximumLevel() < 0) {
				$options = array();
				$options['properties'] = $technology->getInternalName().' AS highest_level';
				$options['order'] = $technology->getInternalName().' DESC';
				$record = Rakuun_DB_Containers_Persistent::getTechnologiesContainer()->selectFirst($options);
				$userLink = new Rakuun_GUI_Control_UserLink('user', $record->user, $record->get('user'));
				$records->addLine(array($technology->getName(), $userLink->render(), $record->highestLevel));
			}
		}
	}
}

?>