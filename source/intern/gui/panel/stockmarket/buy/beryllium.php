<?php

class Rakuun_Intern_GUI_Panel_StockMarket_Buy_Beryllium extends Rakuun_Intern_GUI_Panel_StockMarket {
	
	public function init() {
		parent::init();
		
		$this->addPanel(new GUI_Control_DigitBox('amount', 0, 'Menge', 0, self::getTradable()));
		$factor = new GUI_Panel_Number('buy_beryllium_iron', $this->calculateStockExchangePrice(Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_BERYLLIUM, Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_IRON));
		$this->addPanel($first = new GUI_Control_DigitBox('first', 0, 'Eisen (x '.$factor->render().')'));
		$first->setAttribute('style', 'display: none;');
		$this->addPanel($first_radio = new GUI_Control_RadioButton('first_radio', 1, true));
		$first_radio->setGroup('beryllium');
		$factor = new GUI_Panel_Number('buy_beryllium_energy', $this->calculateStockExchangePrice(Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_BERYLLIUM, Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_ENERGY));
		$this->addPanel($second = new GUI_Control_DigitBox('second', 0, 'Energie (x '.$factor->render().')'));
		$second->setAttribute('style', 'display: none;');
		$this->addPanel($second_radio = new GUI_Control_RadioButton('second_radio', 2, false));
		$second_radio->setGroup('beryllium');
		$this->addPanel(new GUI_Control_Slider('slider'));
	}

	public function afterInit() {
		parent::afterInit();
		
		$this->getModule()->addJsAfterContent(
			$this->getSliderJS(
				Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_BERYLLIUM,
				Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_IRON,
				Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_ENERGY
			)
		);
		$this->getModule()->addJsAfterContent("$('#".$this->first_radio->getID()."').hide(); $('#".$this->second_radio->getID()."').hide();");
	}
}
?>