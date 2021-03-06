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

class Rakuun_Intern_Production_Building_Clonomat extends Rakuun_Intern_Production_Building_RessourceProducer {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('clonomat');
		$this->setName('Clon-O-Mat');
		$this->setBaseIronCosts(440);
		$this->setBaseBerylliumCosts(320);
		$this->setBaseEnergyCosts(1000);
		$this->setBasePeopleCosts(4);
		$this->setBaseTimeCosts(4*60);
		$this->addNeededBuilding('ironmine', 4);
		$this->addNeededBuilding('berylliummine', 3);
		$this->addNeededBuilding('hydropower_plant', 3);
		$this->addNeededTechnology('genetic', 1);
		$this->setBasePeopleProduction(1);
		$this->setShortDescription('Durch den Clon-O-Mat (Kurz: COM) kann die "Produktion" von Rakuuranern erhöht werden.');
		$this->setLongDescription('Der Clon-O-Mat, oder abgekürzt COM, klont die Bevölkerung, sodass das Wachstum derselben extrem beschleunigt wird.
			<br/>
			Dabei werden von einem extrem leistungsfähigen Supercomputer verschiedene Zellproben analysiert und die meistversprechenden werden in ihrer Erbinformation halbiert und mit anderen verschmolzen, sodass eine künstliche Evolution stattfindet.
			<br/>
			Aus den neuen Zellen werden dann wiederum die besten ausgewählt und so verändert, dass Krankheiten mit einer um einiges geringeren Wahrscheinlichkeit auftreten.
			<br/>
			Anschließend werden die Zellen in einer großen Anlage aus einem Wald von Röhren in einer Nährlösung so oft verdoppelt, bis sich erste Organe bilden.
			<br/>
			Dann werden diese Präembryonen mit Schläuchen künstlich mit einem individuell gemischten Cocktail aus Nährstoffen versorgt.
			<br/>
			Sobald die Klone in der Lage sind zu sehen, werden sie, weiterhin mit Schläuchen verbunden, in spezielle Räume gesteckt, in denen sie erstmal das Grundwissen lernen und später auf verschiedene Professionen trainiert werden.
			<br/>
			Mit Vollendung des Wachstumsprozesses, der durch Hormone in der Nährlösung und den Nährstoffen extrem beschleunigt von statten geht, treten die Clone aus der Anlage um arbeitsbereit in ihren Wohneinheiten zu warten.
			<br/>
			Leider ist die psychische Beeinflussung während des Lernprozesses anscheinend nicht prägend genug, sodass es dennoch vorkommen kann, dass die Clone ihre Arbeitsmoral verlieren und zu den Rebellen übertreten; durch das Gefühl, das halbe Leben verpasst zu haben, fühlen sie sich oft zur Rebellion genauso stark hingezogen wie frei Aufgewachsene.');
		$this->setPoints(8);
	}
	
	protected function defineEffects() {
		$producedCurrentLevel = $this->getProducedPeople(time() - 60, $this->getRequiredWorkers($this->getLevel() + $this->getFutureLevels()), $this->getLevel() + $this->getFutureLevels());
		$producedNextLevel = $this->getProducedPeople(time() - 60, $this->getRequiredWorkers($this->getLevel() + $this->getFutureLevels() + 1), $this->getLevel() + $this->getFutureLevels() + 1);
		$this->addEffect('Erhöht die Anzahl der verfügbaren Leute pro Minute um '.Text::formatNumber($producedNextLevel - $producedCurrentLevel));
	}
}

?>