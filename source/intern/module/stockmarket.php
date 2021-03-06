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

class Rakuun_Intern_Module_StockMarket extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Börse');
//		$this->contentPanel->addPanel(new GUI_Panel_Text('bla', 'Die Börse ist gerade auf einem Karnevallsumzug...'));
//		return;
		$this->contentPanel->setTemplate(dirname(__FILE__).'/stockmarket.tpl');
		$ressources = Rakuun_Intern_GUI_Panel_StockMarket::getStockRessources();
		$iron = new GUI_Panel_Number('iron', $ressources[Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_IRON]);
		$beryllium = new GUI_Panel_Number('beryllium', $ressources[Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_BERYLLIUM]);
		$energy = new GUI_Panel_Number('energy', $ressources[Rakuun_Intern_GUI_Panel_StockMarket::RESSOURCE_ENERGY]);
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('poolbox', new GUI_Panel_Text('pool', $iron->render().' Eisen | '.$beryllium->render().' Beryllium | '.$energy->render().' Energie<br />Heute noch handelbare Ressourcen: '.Text::formatNumber(Rakuun_Intern_GUI_Panel_StockMarket::getTradableLeft())), 'Verfügbare Ressourcen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('displaybox', new Rakuun_Intern_GUI_Panel_Stockmarket_Display('display'), 'Kursverlauf'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('buyironbox', new Rakuun_Intern_GUI_Panel_StockMarket_Buy_Iron('iron'), 'Eisen kaufen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('buyberylliumbox', new Rakuun_Intern_GUI_Panel_StockMarket_Buy_Beryllium('beryllium'), 'Beryllium kaufen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('buyenergybox', new Rakuun_Intern_GUI_Panel_StockMarket_Buy_Energy('energy'), 'Energie kaufen'));
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('sellironbox', new Rakuun_Intern_GUI_Panel_StockMarket_Sell_Iron('iron'), 'Eisen verkaufen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('sellberylliumbox', new Rakuun_Intern_GUI_Panel_StockMarket_Sell_Beryllium('beryllium'), 'Beryllium verkaufen'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('sellenergybox', new Rakuun_Intern_GUI_Panel_StockMarket_Sell_Energy('energy'), 'Energie verkaufen'));
		
	}
}
		
?>