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

class Rakuun_Intern_Production_Technology_Genetic extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('genetic');
		$this->setName('Gentechnik');
		$this->setBaseIronCosts(640);
		$this->setBaseBerylliumCosts(640);
		$this->setBaseEnergyCosts(800);
		$this->setBaseTimeCosts(570*60);
		$this->addNeededBuilding('laboratory', 2);
		$this->setMaximumLevel(1);
		$this->setShortDescription('Durch die Gentechnik können Clon-O-Maten gebaut werden, welche die "Produktion" von Rakuuranern erhöhen.');
		$this->setLongDescription('Die Klonung eines Wesens an sich stellt wohl das geringste Problem dar.
			<br/>
			Was an dieser Technik vermutlich das schwerste ist, ist die Verschmelzung und Ausbesserung des Erbgutes sowie die Nährstoffzuflußkontrolle, die ein schnelles Wachstum ermöglicht.
			<br/>
			Natürlich sollen letztendlich leistungsfähige Arbeiter und Krieger entstehen; daher ist es unumgänglich, das Erbgut an einigen Stellen zu verbessern.
			<br/>
			Die in kürzester Zeit gezüchteten Wesen verfügen noch über sehr wenig Wissen und müssen so schnell wie möglich eingeschult werden, was eine verbesserte Hirnleistung nötig macht.
			<br/>
			Auch hatten die Klone keine Zeit, Muskeln zu trainieren und müssen daher mit den modernsten Steroiden hochgepowert werden.');
		$this->setPoints(8);
	}
}

?>