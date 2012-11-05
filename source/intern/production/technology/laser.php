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

class Rakuun_Intern_Production_Technology_Laser extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('laser');
		$this->setName('Lasertechnik');
		$this->setBaseIronCosts(2400);
		$this->setBaseBerylliumCosts(1600);
		$this->setBaseEnergyCosts(800);
		$this->setBasePeopleCosts(800);
		$this->setBaseTimeCosts(48*60);
		$this->addNeededBuilding('laboratory', 1);
		$this->addNeededBuilding('barracks', 1);
		$this->setMaximumLevel(1);
		$this->setShortDescription('Durch die Lasertechnik können Lasereinheiten produziert werden.');
		$this->setLongDescription('Laser ist eine Abkürzung für Light Amplification by Stimulatend Emmission of Radiation, einer Lichtverstärkung durch hervorgerufene Strahlungsemmission oder für Laien eine ungewöhnlich starke Lichtstrahlung, künstlich hervorgerufen durch einige Reaktionen die die Gasteilchen in den Laserkanonen zum strahlen bringen.
			<br/>
			Eine solche Forschung muss auf tausendstel Millimeter perfekt sein wenn nicht sogar mehr.
			<br/>
			Allein die Umsetzung der elektrischen Energie in Emmission ist eine schwere Aufgabe, aber die Bündelung der Lichtwellen zu einem dünnen Strahl ist nochmal ein ganz anderes Kaliber.
			<br/>
			Nur Top-Forschungslabore mit Präzisionsmaschinen sind überhaupt in der Lage, einen einfachen Prototypen herzustellen.');
		$this->setPoints(20);
	}
}

?>