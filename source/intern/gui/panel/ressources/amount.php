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

class Rakuun_Intern_GUI_Panel_Ressources_Amount extends GUI_Panel_Number {
	private $productionRate = 0;
	private $limit = 0;
	
	public function __construct($name, $amount, $productionRate, $limit, $title = '') {
		parent::__construct($name, $amount, $title);
		
		$this->productionRate = $productionRate;
		$this->limit = $limit;
	}
	
	public function init() {
		parent::init();
		
		$this->getModule()->addJsRouteReference('js', 'panel/ressources.js');
	}
	
	public function afterInit() {
		parent::afterInit();
		if ($this->productionRate > 0 && $this->text < $this->limit)
			$this->addJS('new GUI_Control_Ressources("'.$this->getID().'", '.$this->text.', '.$this->productionRate.', '.$this->limit.');');
	}
	
	public function getText() {
		return Text::formatNumber($this->text, 0);
	}
}

?>