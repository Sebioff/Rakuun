<?php

class Rakuun_Intern_GUI_Panel_StockMarket_Sell_Energy extends Rakuun_Intern_GUI_Panel_StockMarket {
	
	public function init() {
		parent::init();
		
		$this->addPanel(new GUI_Control_DigitBox('amount', 0, 'Menge', 0, self::getTradable()));
		$factor = new GUI_Panel_Number('sell_energy_iron', $this->calculateStockExchangePrice(Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_IRON, Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_ENERGY));
		$this->addPanel($first = new GUI_Control_DigitBox('first', 0, 'Eisen (x '.$factor->render().')'));
		$first->setAttribute('style', 'display: none;');
		$this->addPanel($first_radio = new GUI_Control_RadioButton('first_radio', 1, true));
		$first_radio->setGroup('energy');
		$factor = new GUI_Panel_Number('sell_energy_beryllium', $this->calculateStockExchangePrice(Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_BERYLLIUM, Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_ENERGY));
		$this->addPanel($second = new GUI_Control_DigitBox('second', 0, 'Beryllium (x '.$factor->render().')'));
		$second->setAttribute('style', 'display: none;');
		$this->addPanel($second_radio = new GUI_Control_RadioButton('second_radio', 2, false));
		$second_radio->setGroup('energy');
		$this->addPanel(new GUI_Control_Slider('slider'));
	}

	public function afterInit() {
		parent::afterInit();
		
		$this->getModule()->addJsAfterContent(
			$this->getSellSliderJS(
				Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_ENERGY,
				Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_IRON,
				Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_BERYLLIUM
			)
		);
		$this->getModule()->addJsAfterContent("$('#".$this->first_radio->getID()."').hide(); $('#".$this->second_radio->getID()."').hide();");
	}
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$amount = $this->amount->getValue();
		$first = $this->first->getValue();
		$second = $this->second->getValue();
		$energy_iron = $this->calculateStockExchangePrice(parent::RESSOURCE_IRON, parent::RESSOURCE_ENERGY);
		$energy_beryllium = $this->calculateStockExchangePrice(parent::RESSOURCE_BERYLLIUM, parent::RESSOURCE_ENERGY);
		$options = array();
		$options['order'] = 'date DESC';
		$pool = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst($options);
		$iron = $first;
		$beryllium = $second;
		$energy = round(($energy_iron > 0 ? $first / $energy_iron : 0) + ($energy_beryllium > 0 ? $second / $energy_beryllium : 0));
		if ($energy > $amount)
			$energy = $amount;
		if ($first + $second == 0) {
			if ($this->first_radio->getSelected()) {
				$iron = $amount * $energy_iron;
				$beryllium = 0;
				$energy = $amount;
			} else {
				$iron = 0;
				$beryllium = $amount * $energy_beryllium;
				$energy = $amount;
			}
		}
		$this->checkTradable($energy);
		$this->checkCapacities($iron, $beryllium, $energy * -1);
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$user->ressources->raise($iron, $beryllium, 0);
		$user->ressources->lower(0, 0, $energy);
		$pool->iron -= $iron;
		$pool->beryllium -= $beryllium;
		$pool->energy += $energy;
		$pool->save();
		$user->stockmarkettrade += $energy;
		$user->save();
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Du hast '.$energy.' Energie verkauft und dafür '.$iron.' Eisen und '.$beryllium.' Beryllium erhalten.');
		$this->getModule()->invalidate();
	}
}
?>