<?php

class Rakuun_Intern_GUI_Panel_StockMarket extends GUI_Panel {
	/**
	 * BASE_* used for game-reset only
	 */
	const BASE_IRON = 1000000;
	const BASE_BERYLLIUM = 1000000;
	const BASE_ENERGY = 1000000;
	
	const MAX_EXCHANGE_COURSE = 4;
	const MIN_EXCHANGE_COURSE = 0.25;
		
	const RESSOURCE_IRON = 1;
	const RESSOURCE_BERYLLIUM = 2;
	const RESSOURCE_ENERGY = 3;
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/stockmarket.tpl');
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'handeln'));
	}
	
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
			return 0;
		
		$price = $ressources[$sell] / $ressources[$buy];
		if ($ressources[$sell] == 0 || $price > self::MAX_EXCHANGE_COURSE)
			return self::MAX_EXCHANGE_COURSE;
		
		return $price < self::MIN_EXCHANGE_COURSE ? self::MIN_EXCHANGE_COURSE : $price;
	}
	
	/**
	 * get the amount of ressources tradable
	 * @return array with self::RESSOURCE_* as index
	 */
	public static function getStockRessources() {
		$options = array();
		$options['order'] = 'date DESC';
		$ressources = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst($options);
		return array(
			self::RESSOURCE_IRON => $ressources->iron,
			self::RESSOURCE_BERYLLIUM => $ressources->beryllium,
			self::RESSOURCE_ENERGY => $ressources->energy);
	}
	
	protected function checkTradable($amount) {
		$user = Rakuun_User_Manager::getCurrentUser();
		$tradable = self::getTradable();
		if ($amount > $tradable) {
			$this->addError('Du kannst maximal '.GUI_Panel_Number::formatNumber($tradable).' Ressourcen pro Tag über die Börse handeln.');
		}
		if ($amount > $tradable - $user->stockmarkettrade) {
			$this->addError('Du kannst heute nur noch '.GUI_Panel_Number::formatNumber(self::getTradableLeft()).' Ressourcen über die Börse handeln.');
		}
	}
	
	protected function checkCapacities($iron, $beryllium, $energy) {
		$user = Rakuun_User_Manager::getCurrentUser();
		$pool = self::getStockRessources();
		if ($iron > 0) {
			// user gets iron
			if (!$user->ressources->gotEnoughCapacity($iron))
				$this->addError('So viel Eisen kannst du nicht mehr einlagern!');
			if ($pool[self::RESSOURCE_IRON] < $iron)
				$this->addError('So viel Eisen ist nicht mehr im Ressourcenpool vorhanden!');
		} else {
			// user pays with iron
			if ($user->ressources->iron < $iron)
				$this->addError('So viel Eisen hast du nicht!');
		}
		if ($beryllium > 0) {
			// user gets beryllium
			if (!$user->ressources->gotEnoughCapacity($beryllium))
				$this->addError('So viel Beryllium kannst du nicht mehr einlagern!');
			if ($pool[self::RESSOURCE_BERYLLIUM] < $beryllium)
				$this->addError('So viel Beryllium ist nicht mehr im Ressourcenpool vorhanden!');
		} else {
			// user pays with beryllium
			if ($user->ressources->beryllium < $beryllium)
				$this->addError('So viel Beryllium hast du nicht!');
		}
		if ($energy > 0) {
			// user gets energy
			if (!$user->ressources->gotEnoughCapacity($energy))
				$this->addError('So viel Energie kannst du nicht mehr einlagern!');
			if ($pool[self::RESSOURCE_ENERGY] < $energy)
				$this->addError('So viel Energie ist nicht mehr im Ressourcenpool vorhanden!');
		} else {
			// user pays with energy
			if ($user->ressources->energy < $energy)
				$this->addError('So viel Energie hast du nicht!');
		}
	}
	
	protected static function getTradable() {
		return Rakuun_User_Manager::getCurrentUser()->buildings->stockMarket * Rakuun_Intern_Production_Building_StockMarket::TRADELIMIT_PER_LEVEL * RAKUUN_TRADELIMIT_MULTIPLIER;
	}
	
	public static function getTradableLeft() {
		return self::getTradable() - Rakuun_User_Manager::getCurrentUser()->stockmarkettrade;
	}
	
	protected function getSliderJS($buy, $first, $second) {
		return str_replace(array("\r\n", "\n", "\t"), ' ', "
			$('#".$this->first->getID()."').show().attr('readonly', 'readonly');
			$('#".$this->second->getID()."').show().attr('readonly', 'readonly');
		
			$('#".$this->amount->getID()."').change(
				function() {
					$('#".$this->first->getID()."').val(
						Math.round($('#".$this->amount->getID()."').val() * ".$this->calculateStockExchangePrice($buy, $first).")
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