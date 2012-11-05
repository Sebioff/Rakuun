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

class Rakuun_Intern_Production_Building_Berylliumstore extends Rakuun_Intern_Production_Building_Store {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('berylliumstore');
		$this->setName('Berylliumlager');
		$this->setBaseIronCosts(1000);
		$this->setBaseBerylliumCosts(1200);
		$this->setBasePeopleCosts(80);
		$this->setBaseTimeCosts(8*60);
		$this->setBaseCapacity(24000);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Durch den Ausbau des Berylliumlagers wird die Menge des lagerbaren Berylliums erhöht.');
		$this->setLongDescription('Ein Berylliumlager ist ein Komplex mit vielen luftgepolsterten Kammern, der speziell zum Lagern von Beryllium geeignet ist.');
		$this->setPoints(5);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöht die Menge des lagerbaren Berylliums um '.Text::formatNumber($this->getCapacity($this->getLevel() + $this->getFutureLevels() + 1) - $this->getCapacity($this->getLevel() + $this->getFutureLevels())));
	}
}

?>