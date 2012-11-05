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

class Rakuun_Intern_Production_Unit_Mandrogani extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('mandrogani');
		$this->setName('Mandrogani');
		$this->setNamePlural('Mandroganis');
		$this->setBaseIronCosts(420);
		$this->setBaseBerylliumCosts(420);
		$this->setBaseEnergyCosts(440);
		$this->setBasePeopleCosts(12);
		$this->setBaseTimeCosts(14*60);
		$this->setBaseAttackValue(15);
		$this->setBaseDefenseValue(15);
		$this->setBaseSpeed(80);
		$this->setRessourceTransportCapacity(100);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_VEHICLE);
		$this->addNeededBuilding('tank_factory', 15);
		$this->addNeededTechnology('light_plating', 3);
		$this->addNeededTechnology('cloaking', 1);
		$this->setAttribute(Rakuun_Intern_Production_Unit::ATTRIBUTE_CLOAKING, true);
		$this->setShortDescription('Mandrogani');
		$this->setLongDescription('Der Mandrogani ist so ziemlich das weitentwickelste an Technik, was man auf dem Schlachtfeld antreffen kann.
			<br/>
			Für einen Panzer seiner Größe scheint er nur unzureichend gepanzert zu sein, doch seine Technik macht das wieder wett: er verwendet modernste Lasertechnik, mit dem er im Kampf eine Allrounder-Eigenschaft hat, da der sowohl schnelle wie auch starke Laser gegen jeden Typ von Einheit einsetzbar ist.
			<br/>
			Desweiteren besitzt dieser Panzer eine Tarnvorrichtung, die es ihm erlaubt, sowohl schwer vorhersehbare Angriffe durchzuführen, als auch auf dem Schlachtfeld für eine Täuschung des Gegners zu sorgen.
			<br/>
			Leider benötigen die Vorrichtung und der Laser eine Aufwärmzeit, sodass der Mandrogani gewaltige Abstriche im Verteidigungsfall erleiden muss.');
	}
}

?>