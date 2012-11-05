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

/**
 * TODO remove if it is absolutely clear that this won't be used anymore
 * @deprecated
 */
class Rakuun_Intern_Production_Technology_HeavyPlating extends Rakuun_Intern_Production_Technology {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('heavy_plating');
		$this->setName('Schwere Panzerung');
		$this->setBaseIronCosts(1300);
		$this->setBaseBerylliumCosts(800);
		$this->setBaseEnergyCosts(800);
		$this->setBasePeopleCosts(120);
		$this->setBaseTimeCosts(300*60);
		$this->setInfluence(Rakuun_Intern_Production_Technology::INFLUENCE_DEFENSE);
		$this->addNeededBuilding('laboratory', 6);
		$this->addNeededBuilding('tank_factory', 6);
		$this->addNeededTechnology('light_plating', 4);
		$this->setMaximumLevel(4);
		$this->setShortDescription('Zur Produktion stark gepanzerter Einheiten.');
		$this->setLongDescription('Schwere Panzerung ist meist so stabil und mehrschichtig konfiguriert, dass selbst die härtesten Schüsse einfach an ihr abprallen.
			<br/>
			Dafür benötigt es mehrere, dicke und dichte Schichten härtester Metalle wie Titan, die ein enormes Gewicht haben.
			<br/>
			Daher sind besonders die ultraschwer gepanzerten Buhoganis unglaublich langsam und kaum in der Lage, Angriffen auszuweichen.');
		$this->setPoints(10);
	}
}

?>