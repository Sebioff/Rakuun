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

class Rakuun_Intern_Production_Building_Airport extends Rakuun_Intern_Production_Building {
	const PRODUCTION_TIME_REDUCTION_PERCENT = 2;
	
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('airport');
		$this->setName('Flughafen');
		$this->setBaseIronCosts(1200);
		$this->setBaseBerylliumCosts(1600);
		$this->setBaseEnergyCosts(800);
		$this->setBasePeopleCosts(16);
		$this->setBaseTimeCosts(8*60);
		$this->setMaximumLevel(50);
		$this->addNeededBuilding('military_base', 1);
		$this->setShortDescription('Der Flughafen dient als Produktionsanlage und Start- und Landeplatz von Flugeinheiten.<br />Ein Ausbau bewirkt eine schnellere Produktion.');
		$this->setLongDescription('Flughäfen werden für die Konstruktion von Gleitern benötigt.
			<br/>
			Der Flughafen ist ein ziemlich hoher Komplex aus mehren turmartigen Gebilden zwischen denen einzelne Werftdocks an einem Gerüst angebracht sind. Die Türme sind auf verschiedene Bauteile spezialisiert wie Rumpf, Systeme, Waffen oder Anti-G-Einheit, während in den Docks diese Teile dann letztendlich zusammengeschraubt werden.
			<br/>
			Im Zentrum eines Flughafens findet man ein halbkugelförmiges Gebäude, in dem die Piloten während Stunden von Training in den Simulatoren das dreidimensionale Navigieren und Kämpfen in einem Anti-G Feld lernen.
			<br/>
			Nur eine kleine Schar von Leuten wird dann wirklich als Pilot akzeptiert. Ein guter Pilot benötigt nicht nur ausgezeichnete Reflexe und einen ausgeprägten Orientierungssinns, er muss auch nach stundenlangem Flug noch völlig konzentriert sein und auch psychologisch der Aufgabe gewachsen sein.
			<br/>
			Der Job eines Kampfpiloten kann mental Einfachere zermürben und wer nicht fähig ist, in einem Team zu kämpfen, taugt ebenfalls nichts.
			<br/>
			Nur wer sich nach jahrelangem Training bewährt hat, darf die Gerüste erklimmen und im Cockpit eines echten Kampfgleiters sitzen um seinen ersten Einsatz durchzuführen.');
		$this->setPoints(10);
	}
	
	protected function defineEffects() {
		$futureLevel = $this->getLevel() + $this->getFutureLevels();
		$this->addEffect('Verkürzung der Produktionszeit von Flugeinheiten um insgesamt '.$this->getProductionTimeReductionPercent($futureLevel + 1).'% (vorher: '.$this->getProductionTimeReductionPercent($futureLevel).'%)');
	}
	
	private function getProductionTimeReductionPercent($level) {
		return self::PRODUCTION_TIME_REDUCTION_PERCENT * $level;
	}
}

?>