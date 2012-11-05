<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

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