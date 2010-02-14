<?php

class Rakuun_Intern_GUI_Panel_StockMarket extends GUI_Panel {
	/**
	 * BASE_* used for game-reset only
	 */
	const BASE_IRON = 1000000;
	const BASE_BERYLLIUM = 1000000;
	const BASE_ENERGY = 1000000;
	
	const MAX_EXCHANGE_COURSE = 2.5;
		
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
		
		$price = round($ressources[$sell] / ($ressources[$buy]), 3);
		if ($ressources[$sell] == 0 || $price > self::MAX_EXCHANGE_COURSE)
			return self::MAX_EXCHANGE_COURSE;
		
		return $price;
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
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$amount = abs($this->amount->getValue());
		$first = abs($this->first->getValue());
		$second = abs($this->second->getValue());
		$tradable = self::getTradable();
		if ($amount > $tradable) {
			$this->addError('Du kannst maximal '.GUI_Panel_Number::formatNumber($tradable).' Ressourcen pro Tag über die Börse handeln.');
		}
		if ($amount > $tradable - $user->stockmarkettrade) {
			$this->addError('Du kannst heute nur noch '.GUI_Panel_Number::formatNumber(self::getTradableLeft()).' Ressourcen über die Börse handeln.');
		}
		$options = array();
		$options['order'] = 'date DESC';
		$pool = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst($options);
			
		$success = 'Du hast erfolgreich ';
		// TODO lots of duplicate code
		switch (get_class($this)) {
			case 'Rakuun_Intern_GUI_Panel_StockMarket_Buy_Iron':
				if ($first + $second === 0) {
					if ($this->first_radio->getSelected()) {
						$first = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_IRON, self::RESSOURCE_BERYLLIUM);
						$second = 0;
					} else {
						$first = 0;
						$second = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_IRON, self::RESSOURCE_ENERGY);
					}
				}
				$iron = $first / $this->calculateStockExchangePrice(self::RESSOURCE_IRON, self::RESSOURCE_BERYLLIUM);
				$iron += $second / $this->calculateStockExchangePrice(self::RESSOURCE_IRON, self::RESSOURCE_ENERGY);
				$beryllium = $first * -1;
				$energy = $second * -1;
				if ($pool->iron < $iron) {
					$this->addError('So viel Eisen ist nicht mehr im Ressourcenpool vorhanden!');
				}
				if (!$user->ressources->gotEnoughCapacity($iron)) {
					$this->addError('So viel Eisen kannst du nicht mehr einlagern!');
				}
				if ($user->ressources->beryllium < $first) {
					$this->addError('So viel Beryllium hast du nicht!');
				}
				if ($user->ressources->energy < $second) {
					$this->addError('So viel Energie hast du nicht!');
				}
				$success .= abs($beryllium).' Beryllium und '.abs($energy).' Energie gegen '.abs($iron).' Eisen';
			break;
			case 'Rakuun_Intern_GUI_Panel_StockMarket_Buy_Beryllium':
				if ($first + $second === 0) {
					if ($this->first_radio->getSelected()) {
						$first = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_BERYLLIUM, self::RESSOURCE_IRON);
						$second = 0;
					} else {
						$first = 0;
						$second = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_BERYLLIUM, self::RESSOURCE_ENERGY);
					}
				}
				$iron = $first * -1;
				$beryllium = $first / $this->calculateStockExchangePrice(self::RESSOURCE_BERYLLIUM, self::RESSOURCE_IRON);
				$beryllium += $second / $this->calculateStockExchangePrice(self::RESSOURCE_BERYLLIUM, self::RESSOURCE_ENERGY);
				$energy = $second * -1;
				if ($pool->beryllium < $beryllium) {
					$this->addError('So viel Beryllium ist nicht mehr im Ressourcenpool vorhanden!');
				}
				if (!$user->ressources->gotEnoughCapacity(0, $beryllium)) {
					$this->addError('So viel Beryllium kannst du nicht mehr einlagern!');
				}
				if ($user->ressources->iron < $first) {
					$this->addError('So viel Eisen hast du nicht!');
				}
				if ($user->ressources->energy < $second) {
					$this->addError('So viel Energie hast du nicht!');
				}
				$success .= abs($iron).' Eisen und '.abs($energy).' Energie gegen '.abs($beryllium).' Beryllium';
			break;
			case 'Rakuun_Intern_GUI_Panel_StockMarket_Buy_Energy':
				if ($first + $second === 0) {
					if ($this->first_radio->getSelected()) {
						$first = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_ENERGY, self::RESSOURCE_IRON);
						$second = 0;
					} else {
						$first = 0;
						$second = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_ENERGY, self::RESSOURCE_BERYLLIUM);
					}
				}
				$iron = $first * -1;
				$beryllium = $second * -1;
				$energy = $first / $this->calculateStockExchangePrice(self::RESSOURCE_ENERGY, self::RESSOURCE_IRON);
				$energy += $second / $this->calculateStockExchangePrice(self::RESSOURCE_ENERGY, self::RESSOURCE_BERYLLIUM);
				if ($pool->energy < $energy) {
					$this->addError('So viel Energie ist nicht mehr im Ressourcenpool vorhanden!');
				}
				if (!$user->ressources->gotEnoughCapacity(0, 0, $energy)) {
					$this->addError('So viel Energie kannst du nicht mehr einlagern!');
				}
				if ($user->ressources->iron < $first) {
					$this->addError('So viel Eisen hast du nicht!');
				}
				if ($user->ressources->beryllium < $second) {
					$this->addError('So viel Beryllium hast du nicht!');
				}
				$success .= abs($iron).' Eisen und '.abs($beryllium).' Beryllium gegen '.abs($energy).' Energie';
			break;
			
			case 'Rakuun_Intern_GUI_Panel_StockMarket_Sell_Iron':
				if ($first + $second === 0) {
					if ($this->first_radio->getSelected()) {
						$first = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_IRON, self::RESSOURCE_BERYLLIUM);
						$second = 0;
					} else {
						$first = 0;
						$second = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_IRON, self::RESSOURCE_ENERGY);
					}
				}
				$iron = $first / $this->calculateStockExchangePrice(self::RESSOURCE_IRON, self::RESSOURCE_BERYLLIUM);
				$iron += $second / $this->calculateStockExchangePrice(self::RESSOURCE_IRON, self::RESSOURCE_ENERGY);
				$beryllium = $first * -1;
				$energy = $second * -1;
				if ($pool->beryllium < $first) {
					$this->addError('So viel Beryllium ist nicht im Ressourcenpool vorhanden!');
				}
				if ($pool->energy < $second) {
					$this->addError('So viel Energie ist nicht mehr im Ressourcenpool vorhanden!');
				}
				if (!$user->ressources->gotEnoughCapacity(0, $first, $second)) {
					$this->addError('Deine Lager sind zu klein für die Menge Ressourcen!');
				}
				if ($user->ressources->iron < $iron) {
					$this->addError('So viel Eisen hast du nicht!');
				}
				$success .= abs($iron).' Eisen gegen '.abs($beryllium).' Beryllium und '.abs($energy).' Energie';
			break;
			case 'Rakuun_Intern_GUI_Panel_StockMarket_Sell_Beryllium':
				if ($first + $second === 0) {
					if ($this->first_radio->getSelected()) {
						$first = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_BERYLLIUM, self::RESSOURCE_IRON);
						$second = 0;
					} else {
						$first = 0;
						$second = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_BERYLLIUM, self::RESSOURCE_ENERGY);
					}
				}
				$iron = $first * -1;
				$beryllium = $first / $this->calculateStockExchangePrice(self::RESSOURCE_BERYLLIUM, self::RESSOURCE_IRON);
				$beryllium += $second / $this->calculateStockExchangePrice(self::RESSOURCE_BERYLLIUM, self::RESSOURCE_ENERGY);
				$energy = $second * -1;
				if ($pool->iron < $first) {
					$this->addError('So viel Eisen ist nicht im Ressourcenpool vorhanden!');
				}
				if ($pool->energy < $second) {
					$this->addError('So viel Energie ist nicht im Ressourcenpool vorhanden!');
				}
				if (!$user->ressources->gotEnoughCapacity($first, 0, $second)) {
					$this->addError('Deine Lager sind zu klein für die Menge Ressourcen!');
				}
				if ($user->ressources->beryllium < $beryllium) {
					$this->addError('So viel Beryllium hast du nicht!');
				}
				$success .= abs($beryllium).' Beryllium gegen '.abs($iron).' Eisen und '.abs($energy).' Energie';
			break;
			case 'Rakuun_Intern_GUI_Panel_StockMarket_Sell_Energy':
				if ($first + $second === 0) {
					if ($this->first_radio->getSelected()) {
						$first = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_ENERGY, self::RESSOURCE_IRON);
						$second = 0;
					} else {
						$first = 0;
						$second = $amount * $this->calculateStockExchangePrice(self::RESSOURCE_ENERGY, self::RESSOURCE_BERYLLIUM);
					}
				}
				$iron = $first * -1;
				$beryllium = $second * -1;
				$energy = $first / $this->calculateStockExchangePrice(self::RESSOURCE_ENERGY, self::RESSOURCE_IRON);
				$energy += $second / $this->calculateStockExchangePrice(self::RESSOURCE_ENERGY, self::RESSOURCE_BERYLLIUM);
				if ($pool->iron < $first) {
					$this->addError('So viel Eisen ist nicht im Ressourcenpool vorhanden!');
				}
				if ($pool->beryllium < $second) {
					$this->addError('So viel Beryllium ist nicht im Ressourcenpool vorhanden!');
				}
				if (!$user->ressources->gotEnoughCapacity($first, $second)) {
					$this->addError('Deine Lager sind zu klein für die Menge Ressourcen!');
				}
				if ($user->ressources->energy < $energy) {
					$this->addError('So viel Energie hast du nicht!');
				}
				$success .= abs($energy).' Energie gegen '.abs($iron).' Eisen und '.abs($beryllium).' Beryllium';
			break;
		}
		$success .= ' getauscht';
		
		if ($this->hasErrors())
			return;
			
		DB_Connection::get()->beginTransaction();
		if (stristr(get_class($this), 'buy') !== false)
			$user->ressources->raise($iron, $beryllium, $energy);
		else
			$user->ressources->lower($iron, $beryllium, $energy);
		$record = $pool->date < mktime(0, 0, 0) ? new DB_Record() : $pool;
		$record->date = mktime(12, 0, 0);
		$record->iron = $pool->iron - $iron;
		$record->beryllium = $pool->beryllium - $beryllium;
		$record->energy = $pool->energy - $energy;
		Rakuun_DB_Containers::getStockmarketContainer()->save($record);
		$user->stockmarkettrade = $user->stockmarkettrade + $amount;
		Rakuun_User_Manager::update($user);
		DB_Connection::get()->commit();
		$this->setSuccessMessage($success); //FIXME doesn't work?!
		$this->getModule()->invalidate();
	}
	
	protected static function getTradable() {
		return Rakuun_User_Manager::getCurrentUser()->buildings->stockMarket * Rakuun_Intern_Production_Building_StockMarket::TRADELIMIT_PER_LEVEL * RAKUUN_TRADELIMIT_MULTIPLIER;
	}
	
	public static function getTradableLeft() {
		return self::getTradable() - Rakuun_User_Manager::getCurrentUser()->stockmarkettrade;
	}
	
	protected function getSliderJS($buy, $first, $second) {
		return str_replace(array("\r\n", "\n", "\t"), '', "
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