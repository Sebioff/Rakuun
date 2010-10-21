<?php

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