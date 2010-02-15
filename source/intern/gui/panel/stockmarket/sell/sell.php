<?php

class Rakuun_Intern_GUI_Panel_StockMarket_Sell extends Rakuun_Intern_GUI_Panel_StockMarket {
	public function calculateStockExchangePrice($buy, $sell) {
		$ressources = self::getStockRessources();
		if ($ressources[$buy] == 0)
			$price = self::MAX_EXCHANGE_COURSE;
		else
			$price = $ressources[$sell] / $ressources[$buy];
		
		if ($ressources[$sell] == 0)
			$price = self::MIN_EXCHANGE_COURSE;
		
		if ($price > self::MAX_EXCHANGE_COURSE)
			$price = self::MAX_EXCHANGE_COURSE;
		
		if ($price < self::MIN_EXCHANGE_COURSE)
			$price = self::MIN_EXCHANGE_COURSE;
			
		return 1 / $price;
	}
	
	protected function getSliderJS($sell, $first, $second) {
		return str_replace(array("\r\n", "\n", "\t"), ' ', "
			$('#".$this->first->getID()."').show().attr('readonly', 'readonly');
			$('#".$this->second->getID()."').show().attr('readonly', 'readonly');
		
			$('#".$this->amount->getID()."').change(
				function() {
					$('#".$this->first->getID()."').val(
						Math.round($('#".$this->amount->getID()."').val() * ".$this->calculateStockExchangePrice($first, $sell).")
					);
				}
			);
			$('#".$this->slider->getID()."').slider(
				{
					min: 1,
					max: 101,
					slide: function(event, ui) {
						$('#".$this->first->getID()."').val(
							Math.round((101 - ui.value) / 100 * $('#".$this->amount->getID()."').val() * ".$this->calculateStockExchangePrice($first, $sell).")
						);
						$('#".$this->second->getID()."').val(
							Math.round((ui.value - 1) / 100 * $('#".$this->amount->getID()."').val() * ".$this->calculateStockExchangePrice($second, $sell).")
						);
					}
				}
			);
		");
	}
}
?>