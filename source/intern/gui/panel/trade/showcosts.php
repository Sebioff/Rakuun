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

class Rakuun_Intern_GUI_Panel_Trade_ShowCosts extends GUI_Panel {
	
	private $recipient = null;
	private $iron = 0;
	private $beryllium = 0;
	private $energy = 0;
	private $msg = '';
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/showcosts.tpl');
		
		//calc Costs
		$energycosts = $this->energy + ($this->iron + $this->beryllium) / 2;
		$ironcosts = intval($this->iron * 0.1);
		$berylliumcosts = intval($this->beryllium * 0.1);
		
		$this->addPanel($transport = new GUI_Panel_Table('transport', 'Transport von:'));
		$transport->addLine(array('Eisen: '.$this->iron));
		$transport->addLine(array('Beryllium: '.$this->beryllium));
		$transport->addLine(array('Energie: '.$this->energy));
		
		$this->addPanel($transportcosts = new GUI_Panel_Table('transportcosts', 'Transportkosten:'));
		$transportcosts->addLine(array('Eisen: '.$ironcosts));
		$transportcosts->addLine(array('Beryllium: '.$berylliumcosts));
		$transportcosts->addLine(array('Energie: '.$energycosts));
		
		$this->addPanel($wholecosts = new GUI_Panel_Table('holecosts', 'Gesamtkosten:'));
		$wholecosts->addLine(array('Eisen: '.($ironcosts + $this->iron)));
		$wholecosts->addLine(array('Beryllium: '.($berylliumcosts + $this->beryllium)));
		$wholecosts->addLine(array('Energie: '.($energycosts + $this->energy)));
	}
		
	public function setTradeParameters(Rakuun_DB_User $recipient = null, $iron = 0, $beryllium = 0, $energy = 0, $msg = '') {
		$this->recipient = $recipient;
		$this->iron = $iron;
		$this->beryllium = $beryllium;
		$this->energy = $energy;
		$this->msg = $msg;
	}
}

?>