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

class Rakuun_Intern_Production_Unit_Tertor extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('tertor');
		$this->setName('Tertor');
		$this->setNamePlural('Tertoren');
		$this->setBaseIronCosts(280);
		$this->setBaseBerylliumCosts(520);
		$this->setBaseEnergyCosts(400);
		$this->setBasePeopleCosts(8);
		$this->setBaseTimeCosts(16*60);
		$this->setBaseAttackValue(22);
		$this->setBaseDefenseValue(8);
		$this->setBaseSpeed(110);
		$this->setRessourceTransportCapacity(50);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_AIRCRAFT);
		$this->addNeededBuilding('airport', 1);
		$this->addNeededTechnology('plasmatechnology', 1);
		$this->addNeededRequirement(new Rakuun_Intern_Production_Requirement_NotInNoobProtection());
		$this->setShortDescription('Tertor');
		$this->setLongDescription('Tertoren sind Antigrav-Bomber.
			<br/>
			Die großen Bombenschächte und die schweren Bomben kosten die Antigrav Einheit weit mehr Energie als die der Donanies, wodurch sie wesentlich langsamer vorrankommen und sogar von Tegos in Geschwindigkeit übertroffen werden.
			<br/>
			Dafür sind ihre Bomben ziemlich stark und schalten fast jede Verteidigung aus.
			<br/>
			Zusammen mit Buhoganis sind sie eine hervorragende Bunkerbrechungseinheit.
			<br/>
			Leider sind ihre Bomben relativ ungenau wenn es um das treffen zustürmender Einheiten geht, weshalb ihr Verteidigungspotential selbst das von einem Donany unterbietet.');
	}
}

?>