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