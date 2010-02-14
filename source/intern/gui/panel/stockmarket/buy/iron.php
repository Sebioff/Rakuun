<?php

class Rakuun_Intern_GUI_Panel_StockMarket_Buy_Iron extends Rakuun_Intern_GUI_Panel_StockMarket {
	
	public function init() {
		parent::init();
		
		$this->addPanel(new GUI_Control_DigitBox('amount', 0, 'Menge', 0, self::getTradable()));
		$factor = new GUI_Panel_Number('buy_iron_beryllium', $this->calculateStockExchangePrice(Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_IRON, Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_BERYLLIUM)); 
		$this->addPanel($first = new GUI_Control_DigitBox('first', 0, 'Beryllium (&frasl; '.$factor->render().')'));
		$first->setAttribute('style', 'display: none;');
		$this->addPanel($first_radio = new GUI_Control_RadioButton('first_radio', 1, true));
		$first_radio->setGroup('iron');
		$factor = new GUI_Panel_Number('buy_iron_energy', $this->calculateStockExchangePrice(Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_IRON, Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_ENERGY));
		$this->addPanel($second = new GUI_Control_DigitBox('second', 0, 'Energie (&frasl; '.$factor->render().')'));
		$second->setAttribute('style', 'display: none;');
		$this->addPanel($second_radio = new GUI_Control_RadioButton('second_radio', 2, false));
		$second_radio->setGroup('iron');
		$this->addPanel(new GUI_Control_Slider('slider'));
	}

	public function afterInit() {
		parent::afterInit();
		
		$this->getModule()->addJsAfterContent(
			$this->getSliderJS(
				Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_IRON,
				Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_BERYLLIUM,
				Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_ENERGY
			)
		);
		$this->getModule()->addJsAfterContent("$('#".$this->first_radio->getID()."').hide(); $('#".$this->second_radio->getID()."').hide();");
	}
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$amount = $this->amount->getValue();
		$first = $this->first->getValue();
		$second = $this->second->getValue();
		$iron_beryllium = $this->calculateStockExchangePrice(parent::RESSOURCE_IRON, parent::RESSOURCE_BERYLLIUM);
		$iron_energy = $this->calculateStockExchangePrice(parent::RESSOURCE_IRON, parent::RESSOURCE_ENERGY);
		$options = array();
		$options['order'] = 'date DESC';
		$pool = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst($options);
		$iron = round(($iron_beryllium > 0 ? $first / $iron_beryllium : 0) + ($iron_energy > 0 ? $second / $iron_energy : 0));
		if ($iron > $amount)
			$iron = $amount;
		$beryllium = $first;
		$energy = $second;
		if ($first + $second == 0) {
			if ($this->first_radio->getSelected()) {
				$iron = $amount;
				$beryllium = $amount * $iron_beryllium;
				$energy = 0;
			} else {
				$iron = $amount;
				$beryllium = 0;
				$energy = $amount * $iron_energy;
			}
		}
		$this->checkTradable($iron);
		$this->checkCapacities($iron, $beryllium * -1, $energy * -1);
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$user->ressources->raise($iron);
		$user->ressources->lower(0, $beryllium, $energy);
		$pool->iron -= $iron;
		$pool->beryllium += $beryllium;
		$pool->energy += $energy;
		$pool->save();
		$user->stockmarkettrade += $iron;
		$user->save();
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Du hast '.$iron.' Eisen gekauft und mit '.$beryllium.' Beryllium und '.$energy.' Energie bezahlt.');
		$this->getModule()->invalidate();
	}
}
?>