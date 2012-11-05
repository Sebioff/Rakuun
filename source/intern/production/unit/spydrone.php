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

class Rakuun_Intern_Production_Unit_Spydrone extends Rakuun_Intern_Production_Unit {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('spydrone');
		$this->setName('Spionagesonde');
		$this->setNamePlural('Spionagesonden');
		$this->setBaseIronCosts(80);
		$this->setBaseBerylliumCosts(80);
		$this->setBaseEnergyCosts(80);
		$this->setBasePeopleCosts(1);
		$this->setBaseTimeCosts(3*60);
		$this->setBaseSpeed(8);
		$this->addNeededBuilding('military_base', 1);
		$this->addNeededTechnology('sensor_technology', 1);
		$this->setAttribute(Rakuun_Intern_Production_Base::ATTRIBUTE_INDESTRUCTIBLE_BY_ATTACK, true);
		$this->setShortDescription('Spionagesonde');
		$this->setLongDescription('Spionagesonden beruhen auf der ziemlich alten Technik des Etherstreams.
			<br/>
			Geleitet von einer unbekannten Kraft erreichen sie gigantische Geschwindigkeiten. Diese Geschwindigkeiten sind so hoch, dass Spionagesonden in früheren Zeiten nicht mehr bremsen konnten und, nachdem sie von der anvisierten Stadt Aufzeichnungen gemacht haben, durch die Luftreibung überhitzten und explodierten.
			<br/>
			Die Etherstream Technologie eignet sich nicht für wirkliche Kampfeinheiten; die Wissenschaft wäre noch nichtmal in der Lage, Streamgeneratoren für wesentlich größere Gebilde zu bauen.
			<br/>
			<br/>
			Spionagesonden können mit der Verbesserten Tarnung ausgestattete Einheiten <b>nicht</b> erkennen.
			<br/>
			Eine Spionagesonde kann bis zu 2000 Verteidigungskraft standhalten, um unbeschadet zur Heimatstadt zurückzukehren.');
	}
}

?>