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
	
	private $stockRessourcesCache = null;
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/stockmarket.tpl');
		$this->getModule()->addJsRouteReference('js', 'stockmarket.js');
		$this->addPanel(new GUI_Control_DigitBox('amount', 0, 'Menge', 0, self::getTradable()));
		$this->addPanel($first = new GUI_Control_DigitBox('first', 0));
		$first->setAttribute('style', 'display: none;');
		$this->addPanel($first_radio = new GUI_Control_RadioButton('first_radio', 1, true));
		$first_radio->setGroup($this->getName());
		$this->addPanel($second = new GUI_Control_DigitBox('second', 0));
		$second->setAttribute('style', 'display: none;');
		$this->addPanel($second_radio = new GUI_Control_RadioButton('second_radio', 2, false));
		$second_radio->setGroup($this->getName());
		$this->addPanel(new GUI_Control_Slider('slider'));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'handeln'));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->getModule()->addJsAfterContent("$('#".$this->first_radio->getID()."').hide(); $('#".$this->second_radio->getID()."').hide();");
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
	
	protected function getStockRessourcesCached() {
		if ($this->stockRessourcesCache === null)
			$this->stockRessourcesCache = self::getStockRessources();

		return $this->stockRessourcesCache;
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
	
	/**
	 * some checks before trading.
	 * use postive amounts if user get's that ressource, use negative if he pay's with it.
	 */
	protected function checkCapacities($iron, $beryllium, $energy) {
		$user = Rakuun_User_Manager::getCurrentUser();
		$pool = $this->getStockRessourcesCached();
		if ($iron >= 0) {
			// user gets iron
			if (!$user->ressources->gotEnoughCapacity($iron))
				$this->addError('So viel Eisen kannst du nicht mehr einlagern!');
			if (0 < $pool[self::RESSOURCE_IRON] && $pool[self::RESSOURCE_IRON] < $iron)
				$this->addError('So viel Eisen ist nicht mehr im Ressourcenpool vorhanden!');
			if ($pool[self::RESSOURCE_IRON] == 0)
				$this->addError('Es ist kein Eisen mehr im Ressourcenpool vorhanden!');
		} else {
			// user pays with iron
			if ($user->ressources->iron < $iron * -1)
				$this->addError('So viel Eisen hast du nicht!');
		}
		if ($beryllium >= 0) {
			// user gets beryllium
			if (!$user->ressources->gotEnoughCapacity($beryllium))
				$this->addError('So viel Beryllium kannst du nicht mehr einlagern!');
			if (0 < $pool[self::RESSOURCE_BERYLLIUM] && $pool[self::RESSOURCE_BERYLLIUM] < $beryllium)
				$this->addError('So viel Beryllium ist nicht mehr im Ressourcenpool vorhanden!');
			if ($pool[self::RESSOURCE_BERYLLIUM] == 0)
				$this->addError('Es ist kein Beryllium mehr im Ressourcenpool vorhanden!');
		} else {
			// user pays with beryllium
			if ($user->ressources->beryllium < $beryllium * -1)
				$this->addError('So viel Beryllium hast du nicht!');
		}
		if ($energy >= 0) {
			// user gets energy
			if (!$user->ressources->gotEnoughCapacity($energy))
				$this->addError('So viel Energie kannst du nicht mehr einlagern!');
			if (0 < $pool[self::RESSOURCE_ENERGY] && $pool[self::RESSOURCE_ENERGY] < $energy)
				$this->addError('So viel Energie ist nicht mehr im Ressourcenpool vorhanden!');
			if ($pool[self::RESSOURCE_ENERGY] == 0)
				$this->addError('Es ist keine Energie mehr im Ressourcenpool vorhanden!');
		} else {
			// user pays with energy
			if ($user->ressources->energy < $energy * -1)
				$this->addError('So viel Energie hast du nicht!');
		}
	}
	
	protected function createSliderJS($trade, $first, $second) {
		$ressources = $this->getStockRessourcesCached();
		$this->slider->addOnSlideJS("
			amount = $('#".$this->amount->getID()."').val();
			amountFirst = Math.ceil(amount * ((100 - ui.value) / 100));
			amountSecond = amount - amountFirst;
			$('#".$this->first->getID()."').val(							
				SM_trade(amountFirst, ".$ressources[$trade].", ".$ressources[$first].", ".self::MIN_EXCHANGE_COURSE.", ".self::MAX_EXCHANGE_COURSE.")
			);
			$('#".$this->second->getID()."').val(
				SM_trade(amountSecond, ".$ressources[$trade].", ".$ressources[$second].", ".self::MIN_EXCHANGE_COURSE.", ".self::MAX_EXCHANGE_COURSE.")
			);
		");
		$this->getModule()->addJsAfterContent(str_replace(array("\r\n", "\r", "\n", "\t"), " ", "
			$('#".$this->first->getID()."').show().attr('readonly', 'readonly');
			$('#".$this->second->getID()."').show().attr('readonly', 'readonly');
			$('#".$this->amount->getID()."').change(
				function() {
					amount = $('#".$this->amount->getID()."').val();
					amountFirst = Math.ceil(amount * ((100 - $('#".$this->slider->getID()."').slider('value')) / 100));
					amountSecond = amount - amountFirst;
					$('#".$this->first->getID()."').val(
						SM_trade(amountFirst, ".$ressources[$trade].", ".$ressources[$first].", ".self::MIN_EXCHANGE_COURSE.", ".self::MAX_EXCHANGE_COURSE.")
					);
					$('#".$this->second->getID()."').val(
						SM_trade(amountSecond, ".$ressources[$trade].", ".$ressources[$second].", ".self::MIN_EXCHANGE_COURSE.", ".self::MAX_EXCHANGE_COURSE.")
					);
				}
			);
		"));
	}
	
	/**
	 * Calculates the amount of ressources you get for selling another ressource
	 * This function has a javascript representative, see rakuun/www/js/stockmarket.js
	 * @param $tradeAmount The amount of ressources you want to trade
	 * @param $sellWhat The identifier of the sell-ressource, see self::RESSOURCE_*
	 * @param $buyWhat The identifier of the buy-ressource, see self::RESSOURCE_*
	 * @return int The amount of ressources to recieve.
	 */
	protected function trade($tradeAmount, $sellWhat, $buyWhat) {
		$stockRessources = $this->getStockRessourcesCached();
		$tradeBack = 0;
		while ($tradeAmount > 0 && $stockRessources[$buyWhat] > 0) {
			$tradeAmount--;
			$price = $this->calculateStockExchangePrice($stockRessources[$buyWhat], $stockRessources[$sellWhat]);
			$tradeBack += $price;
			$stockRessources[$sellWhat]--;
			$stockRessources[$buyWhat] += $price;
		}
		return ceil($tradeBack);
	}
	
	/**
	 * calculates the factor for buying one ressource with another.
	 * Needs the pool ressources as params
	 * @param $buy the ressource you want to buy
	 * @param $sell the ressource to pay with
	 * @return factor
	 */
	protected function calculateStockExchangePrice($buy, $sell) {
		if ($buy == 0)
			$price = self::MAX_EXCHANGE_COURSE;
		else
			$price = $sell / $buy;
			
		if ($sell == 0)
			$price = self::MIN_EXCHANGE_COURSE;
			
		if ($price < self::MIN_EXCHANGE_COURSE)
			$price = self::MIN_EXCHANGE_COURSE;
			
		if ($price > self::MAX_EXCHANGE_COURSE)
			$price = self::MAX_EXCHANGE_COURSE; 
		
		return $price;	
	}
	
	protected static function getTradable() {
		return Rakuun_User_Manager::getCurrentUser()->buildings->stockMarket * Rakuun_Intern_Production_Building_StockMarket::TRADELIMIT_PER_LEVEL * RAKUUN_TRADELIMIT_MULTIPLIER;
	}
	
	public static function getTradableLeft() {
		return self::getTradable() - Rakuun_User_Manager::getCurrentUser()->stockmarkettrade;
	}
}
?>