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

class Rakuun_Intern_Production_Unit_Lorica extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('lorica');
		$this->setName('Lorica');
		$this->setNamePlural('Loricas');
		$this->setBaseIronCosts(420);
		$this->setBaseBerylliumCosts(420);
		$this->setBaseEnergyCosts(440);
		$this->setBasePeopleCosts(12);
		$this->setBaseTimeCosts(14*60);
		$this->setBaseAttackValue(15);
		$this->setBaseDefenseValue(15);
		$this->setBaseSpeed(80);
		$this->setRessourceTransportCapacity(1000);
		$this->setUnitType(Rakuun_Intern_Production_Unit::TYPE_FOOTSOLDIER);
		$this->addNeededBuilding('barracks', 15);
		$this->addNeededTechnology('cybernetics', 3);
		$this->addNeededTechnology('supercompression', 1);
		$this->setShortDescription('Lorica');
		$this->setLongDescription('Loricas sind sogenannte BMTs, bemannte Mannschafts-Transporter.
			<br/>
			Sie dienen ausschließlich dem Personen- und Fahrzeugtransport und sind insofern auch unbewaffnet (abgesehen natürlich von der transportierten Infanterie), wenngleich sie eine einfache Panzerung besitzen.
			<br/>
			Die Fahrzeuge sind sehr schnell und wurden dafür entworfen, schnelle Plünderungen durchzuführen, wenngleich auch andere Anwendungsweisen denkbar sind.');
	}
}

?>