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

class Rakuun_Intern_GUI_Panel_Stockmarket_Display extends GUI_Panel {
	
	public function init() {
		parent::init();
		$options = array();
		$options['order'] = 'DATE DESC';
		$options['limit'] = 25;
		$prices = array_reverse(Rakuun_DB_Containers::getStockmarketContainer()->select($options));
		$names = array();
		$iron = array();
		$beryllium = array();
		$energy = array();
		foreach ($prices as $price) {
			$names[] = date('d.m.y', $price->date);
			$iron[] = $price->iron;
			$beryllium[] = $price->beryllium;
			$energy[] = $price->energy;
		}
		if (count($names) > 1) {
			$this->addPanel($plot = new GUI_Panel_Plot_Lines('display', 600, 350));
			$plot->addLine($iron, 'Eisen', 'green');
			$plot->addLine($beryllium, 'Beryllium', 'blue');
			$plot->addLine($energy, 'Energie', 'red');
			$plot->setXNames($names);
		} else {
			$this->addPanel(new GUI_Panel_Text('display', 'No Stockprices yet'));
		}
	}
	public function help() {
		$price = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst();
		for ($i = 1; $i < 30; $i++) {
			$record = new DB_Record();
			$record->date = $price->date - ($i * 60 * 60 * 24);
			$record->iron = $price->iron + (rand(1, 10000) * (rand(1, 2) == 1 ? 1 : -1));
			$record->beryllium = $price->beryllium + (rand(1, 10000) * (rand(1, 2) == 1 ? 1 : -1));
			$record->energy = $price->energy + (rand(1, 10000) * (rand(1, 2) == 1 ? 1 : -1));
			Rakuun_DB_Containers::getStockmarketContainer()->save($record);
		}
	}
}
?>