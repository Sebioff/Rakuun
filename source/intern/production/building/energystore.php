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

class Rakuun_Intern_Production_Building_Energystore extends Rakuun_Intern_Production_Building_Store {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('energystore');
		$this->setName('Energiespeicher');
		$this->setBaseIronCosts(1500);
		$this->setBaseBerylliumCosts(1500);
		$this->setBasePeopleCosts(100);
		$this->setBaseTimeCosts(8*60);
		$this->setBaseCapacity(24000);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Durch den Ausbau des Energiespeichers wird die Menge der speicherbaren Energie erhöht.');
		$this->setLongDescription('Ein Energiespeicher besteht aus einer gigantischen Anzahl hochkapazitärer Kondensatoren in einer magnetisch isolierenden Hülle und wird speziell zum Speichern von Energie gebaut.');
		$this->setPoints(5);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöht die Kapazität der speicherbaren Energie um '.Text::formatNumber($this->getCapacity($this->getLevel() + $this->getFutureLevels() + 1) - $this->getCapacity($this->getLevel() + $this->getFutureLevels())));
	}
}

?>