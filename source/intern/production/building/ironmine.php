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

class Rakuun_Intern_Production_Building_Ironmine extends Rakuun_Intern_Production_Building_RessourceProducer {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('ironmine');
		$this->setName('Eisenmine');
		$this->setBaseIronCosts(240);
		$this->setBaseBerylliumCosts(180);
		$this->setBasePeopleCosts(10);
		$this->setBaseTimeCosts(3*60);
		$this->setBaseIronProduction(1);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Die Eisenmine liefert mehr Eisen, wenn sie ausgebaut wird und mehr Arbeiter in ihr sind. Eisen ist einer der beiden Grundrohstoffe, der für sämtliche Gebäude benötigt wird.');
		$this->setLongDescription('Die Eisenmine ist eine Mine, in der Eisen gewonnen wird.
			<br/>
			Eisen ist ein magnetisches, formbares silbrigweißes metallisches
			Element, welches für die Herstellung von Gebrauchsgegenständen, wie z.B.
			Werkzeuge oder für Ornamente verwendet wird.
			<br/>
			Dieses Element kann in verarbeiteter Form z. B. als Schmiedeeisen,
			Gusseisen oder Stahl verwendet werden.
			<br/>
			Es ist einer der grundlegenden Rohstoffe.');
		$this->setPoints(3);
	}
	
	protected function defineEffects() {
		$producedCurrentLevel = $this->getProducedIron(time() - 60, $this->getRequiredWorkers($this->getLevel() + $this->getFutureLevels()), $this->getLevel() + $this->getFutureLevels());
		$producedNextLevel = $this->getProducedIron(time() - 60, $this->getRequiredWorkers($this->getLevel() + $this->getFutureLevels() + 1), $this->getLevel() + $this->getFutureLevels() + 1);
		$this->addEffect('Erhöht die Menge des abgebauten Eisens pro Minute um '.Text::formatNumber($producedNextLevel - $producedCurrentLevel));
	}
}

?>