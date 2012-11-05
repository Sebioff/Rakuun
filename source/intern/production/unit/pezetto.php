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

class Rakuun_Intern_Production_Unit_Pezetto extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('pezetto');
		$this->setName('Pezetto');
		$this->setNamePlural('Pezettos');
		$this->setBaseIronCosts(20);
		$this->setBaseBerylliumCosts(10);
		$this->setBasePeopleCosts(1);
		$this->setBaseTimeCosts(1*60);
		$this->setBaseDefenseValue(1);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_STATIONARY);
		$this->addNeededBuilding('barracks', 1);
		$this->setShortDescription('Pezetto');
		$this->setLongDescription('Von langen Schlachten in schwere Mitleidenschaft gezogen, ergriffen einige mutige Arbeiter primitive Waffen längst vergangener Tage wie Laserbohrer oder simple Halbautomatik-Waffen um dem Feind trotzen zu können.
			<br/>
			Da sich die Arbeiter größtenteils selbst verpflegen und ausrüsten, benötigt man für ihre Ausbildung nur geringe Ressourcenmengen für Waffen und eine simple Grundkampfschulung.
			<br/>
			Ihre billige Ausbildung macht, strategisch gesehen, ihre fehlende Kampfkraft wett. Die Arbeiter sind aber immer noch Arbeiter, die sich nur verteidigen wollen und somit nicht als Angriffseinheit fungieren. Desweiteren gibt es unter den Arbeitern in Friedenszeiten kein Bestreben, die Waffe zu ergreifen, im Gegenteil, Pezettos legen nach einiger Zeit geleistetem Dienst wieder ihre Waffe nieder.');
	}
}

?>