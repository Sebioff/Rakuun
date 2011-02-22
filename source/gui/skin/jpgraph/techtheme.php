<?php

class Rakuun_GUI_Skin_JPGraph_TechTheme extends UniversalTheme {
	public function __construct() {
		$this->background_color = '#363840';
		$this->font_color = '#FFFFFF';
		$this->grid_color = '#78787D';
	}
	
	function SetupGraph($graph) {
		parent::SetupGraph($graph);
		
		$graph->SetMarginColor(array(205,220,205));
		$graph->SetBox(true, '#78787D');
		$graph->ygrid->SetFill(true, '#44454b', $this->background_color);
		$graph->legend->SetColor($this->font_color, '#363840');
		$graph->legend->SetFillColor($this->background_color);
		$graph->SetFrame(true, $this->background_color, 1);
		$graph->SetMarginColor($this->background_color);
	}
}

?>