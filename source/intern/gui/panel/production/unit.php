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

class Rakuun_Intern_GUI_Panel_Production_Unit extends Rakuun_Intern_GUI_Panel_Production_Production {
	public function init() {
		parent::init();
		
		$this->addPanel(new GUI_Control_DigitBox('amount', 0, 'Anzahl'));
		$this->produce->setValue('Produzieren');
		$this->setTemplate(dirname(__FILE__).'/production_unit.tpl');
	}
	
	public function onProduce() {
		$amount = $this->amount->getValue();
		
		if ($amount <= 0)
			$this->addError('Mindestens 1 Einheit muss produziert werden');
		
		if (!$this->getProductionItem()->meetsTechnicalRequirements())
			$this->addError('Fehlende technische Voraussetzungen');
		
		if (!$this->getProductionItem()->gotEnoughRessources($amount))
			$this->addError('Fehlende Ressourcen');
		
		if (!$this->getProductionItem()->canBuild($amount))
			$this->addError('Kann nicht hergestellt werden');
		
		if ($this->hasErrors()) {
			return;
		}
		
		DB_Connection::get()->beginTransaction();
		$ironCosts = $this->getProductionItem()->getIronCostsForAmount($amount);
		$berylliumCosts = $this->getProductionItem()->getBerylliumCostsForAmount($amount);
		$energyCosts = $this->getProductionItem()->getEnergyCostsForAmount($amount);
		$peopleCosts = $this->getProductionItem()->getPeopleCostsForAmount($amount);
		$this->getProductionItem()->getUser()->ressources->lower($ironCosts, $berylliumCosts, $energyCosts, $peopleCosts);
		$record = new DB_Record();
		$record->user = $this->getProductionItem()->getUser();
		$record->unit = $this->getProductionItem()->getInternalName();
		$record->amount = $amount;
		$record->starttime = time();
		Rakuun_DB_Containers::getUnitsWIPContainer()->save($record);
		$record->position = $record->getPK();
		$record->save();
		DB_Connection::get()->commit();
		Router::get()->getCurrentModule()->invalidate();
	}
}

?>