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

class Rakuun_Intern_Production_Building_House extends Rakuun_Intern_Production_Building_Store {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('house');
		$this->setName('Wohnhaus');
		$this->setBaseIronCosts(1800);
		$this->setBaseBerylliumCosts(600);
		$this->setBasePeopleCosts(120);
		$this->setBaseTimeCosts(8*60);
		$this->setBaseCapacity(4800);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Jedes Wohnhaus erhöht die Anzahl der Bürger, die in der Stadt wohnen können.');
		$this->setLongDescription('Wohnhäuser sind größere Gebäude mit einer großen Anzahl Standard-Wohneinheiten.
			<br/>
			Da sie für die arbeitende Bevölkerung vorgesehen sind, sind es eher einfache aber dennoch recht passable Wohnungen.');
		$this->setPoints(5);
	}
	
	protected function defineEffects() {
		$this->addEffect('Erhöht die Menge der Leute die in der Stadt wohnen können um '.Text::formatNumber($this->getCapacity($this->getLevel() + $this->getFutureLevels() + 1) - $this->getCapacity($this->getLevel() + $this->getFutureLevels())));
	}
}

?>