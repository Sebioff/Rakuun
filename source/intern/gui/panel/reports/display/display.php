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

abstract class Rakuun_Intern_GUI_Panel_Reports_Display extends GUI_Panel {
	private $data = array();
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/display.tpl');
		
		if (isset($this->data['reports'])) {
			$graph = new GUI_Panel_Plot_Lines('graph_'.$this->getName(), 450);
			$graph->setLegendPosition(GUI_Panel_Plot::LEGEND_POSITION_EAST);
			foreach ($this->data['reports'] as $name => $set) {
				$graph->addLine($set, $name);
			}
			$graph->setXNames($this->data['date']);
			$graph->getGraph()->img->setMargin(30, 110, 10, 70);
			if (count(reset($this->data['reports'])) > 1)
				$this->addPanel($graph);
		}
	}
	
	protected function setData(array $data) {
		$this->data = $data;
	}
}
?>