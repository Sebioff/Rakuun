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

class Rakuun_Intern_GUI_Panel_StockMarket_Buy extends Rakuun_Intern_GUI_Panel_StockMarket {
	/**
	 * calculates the factor for buying one ressource with another.
	 * Use self::RESSOURCE_* to identify the specific ressources.
	 * @param $buy the ressource you want to buy
	 * @param $sell the ressource to pay with
	 * @return factor
	 */
	public function calculateStockExchangePrice($buy, $sell) {
		$ressources = self::getStockRessources();
		if ($ressources[$buy] == 0)
			return self::MAX_EXCHANGE_COURSE;
		
		$price = $ressources[$sell] / $ressources[$buy];
		if ($ressources[$sell] == 0 || $price < self::MIN_EXCHANGE_COURSE)
			return self::MIN_EXCHANGE_COURSE;
		
		return $price > self::MAX_EXCHANGE_COURSE ? self::MAX_EXCHANGE_COURSE : $price;
	}
	
	protected function getSliderJS($buy, $first, $second) {
		return str_replace(array("\r\n", "\n", "\t"), ' ', "
			$('#".$this->first->getID()."').show().attr('readonly', 'readonly');
			$('#".$this->second->getID()."').show().attr('readonly', 'readonly');
		
			$('#".$this->amount->getID()."').change(
				function() {
					$('#".$this->first->getID()."').val(
						Math.round((101 - $('#".$this->slider->getID()."').slider('value')) / 100 * $('#".$this->amount->getID()."').val() * ".$this->calculateStockExchangePrice($buy, $first).")
					);
					$('#".$this->second->getID()."').val(
						Math.round(($('#".$this->slider->getID()."').slider('value') - 1) / 100 * $('#".$this->amount->getID()."').val() * ".$this->calculateStockExchangePrice($buy, $second).")
					);
				}
			);
			$('#".$this->slider->getID()."').slider(
				{
					min: 1,
					max: 101,
					slide: function(event, ui) {
						$('#".$this->first->getID()."').val(
							Math.round((101 - ui.value) / 100 * $('#".$this->amount->getID()."').val() * ".$this->calculateStockExchangePrice($buy, $first).")
						);
						$('#".$this->second->getID()."').val(
							Math.round((ui.value - 1) / 100 * $('#".$this->amount->getID()."').val() * ".$this->calculateStockExchangePrice($buy, $second).")
						);
					}
				}
			);
		");
	}
}
?>