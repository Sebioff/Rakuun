<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

class Rakuun_Intern_GUI_Panel_StockMarket_Buy_Beryllium extends Rakuun_Intern_GUI_Panel_StockMarket_Buy {
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
	}
	
	public function onSubmit() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$amount = $this->amount->getValue();
		$first = $this->first->getValue();
		$second = $this->second->getValue();
		$beryllium_iron = $this->calculateStockExchangePrice(parent::RESSOURCE_BERYLLIUM, parent::RESSOURCE_IRON);
		$beryllium_energy = $this->calculateStockExchangePrice(parent::RESSOURCE_BERYLLIUM, parent::RESSOURCE_ENERGY);
		$options = array();
		$options['order'] = 'date DESC';
		$pool = Rakuun_DB_Containers::getStockmarketContainer()->selectFirst($options);
		$iron = $first;
		$beryllium = round(($beryllium_iron > 0 ? $first / $beryllium_iron : 0) + ($beryllium_energy > 0 ? $second / $beryllium_energy : 0));
		$energy = $second;
		if ($first + $second == 0) {
			if ($this->first_radio->getSelected()) {
				$iron = $amount * $beryllium_iron;
				$beryllium = $amount;
				$energy = 0;
			} else {
				$iron = 0;
				$beryllium = $amount;
				$energy = $amount * $beryllium_energy;
			}
		}
		$this->checkTradable($beryllium);
		$this->checkCapacities($iron * -1, $beryllium, $energy * -1);
		if ($this->hasErrors())
			return;
		
		DB_Connection::get()->beginTransaction();
		$user->ressources->raise(0, $beryllium);
		$user->ressources->lower($iron, 0, $energy);
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