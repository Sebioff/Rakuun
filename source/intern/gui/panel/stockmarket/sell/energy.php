<?php

class Rakuun_Intern_GUI_Panel_StockMarket_Sell_Energy extends Rakuun_Intern_GUI_Panel_StockMarket {
	public function init() {
		parent::init();
		
		$ressources = $this->getStockRessourcesCached();
		$factor = new GUI_Panel_Number('sell_energy_iron', 1 / $this->calculateStockExchangePrice($ressources[parent::RESSOURCE_ENERGY], $ressources[parent::RESSOURCE_IRON]));
		$this->first->setTitle('Eisen (* '.$factor->render().')');
		$factor = new GUI_Panel_Number('sell_energy_beryllium',  1 /$this->calculateStockExchangePrice($ressources[parent::RESSOURCE_ENERGY], $ressources[parent::RESSOURCE_BERYLLIUM]));
		$this->second->setTitle('Beryllium (* '.$factor->render().')');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->createSliderJS(parent::RESSOURCE_ENERGY, parent::RESSOURCE_IRON, parent::RESSOURCE_BERYLLIUM);
	}
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$amount = $this->amount->getValue();
		if ($this->first->getValue() + $this->second->getValue() == 0) {
			// selected by radio-buttons
			$percent = $this->first_radio->getSelected() ? 100 : 0;
		} else {
			// selected by slider
			$percent = 100 - $this->slider->getValue();
		}
		$amountFirst = ceil($amount * ($percent / 100));
		$amountSecond = $amount - $amountFirst;
		$iron = $this->trade($amountFirst, parent::RESSOURCE_ENERGY, parent::RESSOURCE_IRON);
		$beryllium = $this->trade($amountSecond, parent::RESSOURCE_ENERGY, parent::RESSOURCE_BERYLLIUM);
		$energy = $amount;
		$this->checkTradable($energy);
		$this->checkCapacities($iron, $beryllium, $energy * -1);
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$user->ressources->raise($iron, $beryllium, 0);
		$user->ressources->lower(0, 0, $energy);
		$options = array();
		$options['order'] = 'date DESC';
		$pool = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst($options);
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