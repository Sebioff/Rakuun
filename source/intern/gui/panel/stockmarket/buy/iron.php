<?php

class Rakuun_Intern_GUI_Panel_StockMarket_Buy_Iron extends Rakuun_Intern_GUI_Panel_StockMarket {
	public function init() {
		parent::init();
		
		$ressources = $this->getStockRessourcesCached();
		$factor = new GUI_Panel_Number('buy_iron_beryllium', $this->calculateStockExchangePrice($ressources[parent::RESSOURCE_IRON], $ressources[parent::RESSOURCE_BERYLLIUM]));
		$this->first->setTitle('Beryllium (&frasl; '.$factor->render().')');
		$factor = new GUI_Panel_Number('buy_iron_energy', $this->calculateStockExchangePrice($ressources[parent::RESSOURCE_IRON], $ressources[parent::RESSOURCE_ENERGY]));
		$this->second->setTitle('Energie (&frasl; '.$factor->render().')');
	}

	public function afterInit() {
		parent::afterInit();
		
		$this->createSliderJS(parent::RESSOURCE_IRON, parent::RESSOURCE_BERYLLIUM, parent::RESSOURCE_ENERGY);
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
		$iron = $amount;
		$beryllium = $this->trade($amountFirst, parent::RESSOURCE_IRON, parent::RESSOURCE_BERYLLIUM); 
		$energy = $this->trade($amountSecond, parent::RESSOURCE_IRON, parent::RESSOURCE_ENERGY);
		$this->checkTradable($iron);
		$this->checkCapacities($iron, $beryllium * -1, $energy * -1);
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$user->ressources->raise($iron);
		$user->ressources->lower(0, $beryllium, $energy);
		$options = array();
		$options['order'] = 'date DESC';
		$pool = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst($options);
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