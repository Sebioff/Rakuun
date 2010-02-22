<?php

class Rakuun_Intern_GUI_Panel_StockMarket_Buy_Beryllium extends Rakuun_Intern_GUI_Panel_StockMarket {
	public function init() {
		parent::init();
		
		$ressources = $this->getStockRessourcesCached();
		$factor = new GUI_Panel_Number('buy_beryllium_iron', $this->calculateStockExchangePrice($ressources[parent::RESSOURCE_BERYLLIUM], $ressources[parent::RESSOURCE_IRON]));
		$this->first->setTitle('Eisen (&frasl; '.$factor->render().')');
		$factor = new GUI_Panel_Number('buy_beryllium_energy', $this->calculateStockExchangePrice($ressources[parent::RESSOURCE_BERYLLIUM], $ressources[parent::RESSOURCE_ENERGY]));
		$this->second->setTitle('Energie (&frasl; '.$factor->render().')');
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->createSliderJS(parent::RESSOURCE_BERYLLIUM, parent::RESSOURCE_IRON, parent::RESSOURCE_ENERGY);
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
		$iron = $this->trade($amountFirst, parent::RESSOURCE_BERYLLIUM, parent::RESSOURCE_IRON);
		$beryllium = $amount;
		$energy = $this->trade($amountSecond, parent::RESSOURCE_BERYLLIUM, parent::RESSOURCE_ENERGY);
		$this->checkTradable($beryllium);
		$this->checkCapacities($iron * -1, $beryllium, $energy * -1);
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$user->ressources->raise(0, $beryllium);
		$user->ressources->lower($iron, 0, $energy);
		$options = array();
		$options['order'] = 'date DESC';
		$pool = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst($options);
		$pool->iron += $iron;
		$pool->beryllium -= $beryllium;
		$pool->energy += $energy;
		$pool->save();
		$user->stockmarkettrade += $beryllium;
		$user->save();
		DB_Connection::get()->commit();
		$this->setSuccessMessage('Du hast '.$beryllium.' Beryllium gekauft und mit '.$iron.' Eisen und '.$energy.' Energie bezahlt.');
		$this->getModule()->invalidate();
	}
}
?>