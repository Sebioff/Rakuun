<?php

class Rakuun_Index_Panel_Endscore_ProducedUnits extends GUI_Panel_Plot_Lines {
	public function __construct($name, $description = '', $title = '') {
		parent::__construct($name, 845, 300, $description, $title);
	}
	
	public function init() {
		parent::init();
		
		$graph = $this->getGraph();
		$graph->legend->SetLayout(LEGEND_VERT);
		$graph->legend->Pos(0.78, 0.12, 'left', 'top');
		$graph->SetMargin(60, 180, 35, 65);
		
		$properties = array();
		$properties[] = 'time';
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			$properties[] = 'SUM('.$unit->getInternalName().') AS '.$unit->getInternalName().'_sum';
		}
		$options = array();
		$options['properties'] = implode(', ', $properties);
		$options['group'] = 'time';
		$lines = array();
		$markers = array();
		foreach (Rakuun_DB_Containers_Persistent::getLogUnitsProductionContainer()->select($options) as $dayData) {
			foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
				$lines[$unit->getInternalName()][] = $dayData->{Text::underscoreToCamelCase($unit->getInternalName().'_sum')};
			}
			$markers[] = date('d.m.', $dayData->time);
		}
		
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			$this->addLine($lines[$unit->getInternalName()], $unit->getNameForAmount(2));
		}
		
		$this->setXNames($markers);
		$this->setXTickInterval(10);
	}
}

?>